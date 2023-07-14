<?php namespace App\Http\Controllers;

use Cache;
use Doctrine\DBAL\Query\QueryBuilder;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\City;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Settings;
use Fanky\Auth\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use SEOMeta;
use Session;
use Request;
use View;

class CatalogController extends Controller {

    public function region_index($city) {
        $this->city = City::current($city);

        return $this->index();
    }

    public function region_view($city_alias, $alias) {
        $this->city = City::current($city_alias);

        return $this->view($alias);
    }

    public function index() {
        $page = Page::getByPath(['catalog']);
        if (!$page) return abort(404);
        $bread = $page->getBread();
        $page->h1 = $page->getH1();
        $page->setSeo();

        $categories = Catalog::getTopLevelOnList();

        return view('catalog.index', [
            'h1' => $page->h1,
            'text' => $page->text,
            'title' => $page->title,
            'bread' => $bread,
            'categories' => $categories,
        ]);
    }

    public function view($alias) {
        $path = explode('/', $alias);
        /* проверка на продукт в категории */
        $product = null;
        $end = array_pop($path);
        $category = Catalog::getByPath($path);
        if ($category && $category->published) {
            $product = Product::whereAlias($end)
                ->public()
                ->whereCatalogId($category->id)->first();
        }
        if ($product) {
            return $this->product($product);
        } else {
            array_push($path, $end);

            return $this->category($path + [$end]);
        }
    }

    public function category($path) {
        /** @var Catalog $category */
        $category = Catalog::getByPath($path);
        if (!$category || !$category->published) abort(404, 'Страница не найдена');
        $bread = $category->getBread();
        $category->setSeo();
        if (count(request()->query())) {
            SEOMeta::setCanonical($category->url);
            $canonical = $category->url;
        } else {
            $canonical = null;
        }

        $root = $category;
        while ($root->parent_id !== 0) {
            $root = $root->findRootCategory($root->parent_id);
        }

        $view = $category->parent_id == 0 ? 'catalog.sub_category' : 'catalog.category';

        $rootIds = Catalog::where('parent_id', 0)->pluck('id')->all();
        if (in_array($category->parent_id, $rootIds) && $root->is_table == 1) {
            $view = 'catalog.sub_category_table';
            $children = $category->children;
            $items = collect();

            foreach ($children as $child) {
                $prods = $child->products()->orderBy('name')->get();
                $items->push([$child->name => ['url' => $child->url, 'value' => $prods->chunk(4)]]);
            }
        } else {
            $per_page = Settings::get('product_per_page') ?: 9;
            $data['per_page'] = $per_page;
            $items = $category->getRecurseProducts()->paginate($per_page);
        }

        Auth::init();
        if (Auth::user() && Auth::user()->isAdmin) {
            View::share('admin_edit_link', route('admin.catalog.catalogEdit', [$category->id]));
        }

        $data = [
            'bread' => $bread,
            'category' => $category,
            'canonical' => $canonical,
            'h1' => $category->getH1(),
            'items' => $items,
            'asideName' => $root->name,
            'root' => $root,
        ];

        if (Request::ajax()) {
            $view_items = [];
            foreach ($items as $item) {
                $view_items[] = view('catalog.product_item', [
                    'item' => $item,
                    'category' => $category,
                    'per_page' => $per_page
                ])->render();
            }

            return response()->json([
                'items' => $view_items,
                'paginate' => view('catalog.section_pagination', [
                    'paginator' => $items,
                ])->render(),
            ]);
        }

        return view($view, $data);
    }

    public function product(Product $product) {
        $bread = $product->getBread();
        $rawSimilarName = $product->name;
        $product->generateTitle();
        $product->generateDescription();
        $product->generateText();
        $product->setSeo();
        $categories = Catalog::getTopLevelOnList();

        $catalog = Catalog::whereId($product->catalog_id)->first();
        $root = $catalog;
        while ($root->parent_id !== 0) {
            $root = $root->findRootCategory($root->parent_id);
        }

        $relatedIds = $product->related()->get()->pluck('related_id'); //похожие товары добавленные из админки
        $related = Product::whereIn('id', $relatedIds)->get();

        //наличие в корзине
        $in_cart = false;
        if (Session::get('cart')) {
            $cart = array_keys(Session::get('cart'));
            if ($cart) {
                $in_cart = in_array($product->id, $cart);
            }
        }

        $images = $product->images;
        if(!count($images)) {
            $img = Catalog::whereId($product->catalog_id)->first()->section_image;
            if (!$img) $img = Catalog::UPLOAD_URL . Catalog::whereId($product->catalog_id)->first()->image;
            $images = collect([
                (object) [
                    'image' => $img
                ]
            ]);
        }

        $text = $product->text ?: $root->text;
        if($root->id == 1) {
            $chars = $product->chars_text ?: $catalog->chars;
        } else {
            $chars = $product->chars;
        }

        $similarName = explode(' ', $rawSimilarName)[0];
        $similar = Product::where('catalog_id', $product->catalog_id)->where('alias', '<>', $product->alias)->where('name', 'like', $similarName . '%')->get();
        if (count($similar) > 10) {
            $similar = $similar->random(10);
        }

        Auth::init();
        if (Auth::user() && Auth::user()->isAdmin) {
            View::share('admin_edit_link', route('admin.catalog.productEdit', [$product->id]));
        }

        return view('catalog.product', [
            'product' => $product,
            'category' => $catalog,
            'categories' => $categories,
            'in_cart' => $in_cart,
            'text' => $text,
            'bread' => $bread,
            'name' => $product->name,
            'related' => $related,
            'images' => $images,
            'cat_image' => $cat_image ?? null,
            'chars' => $chars,
            'root' => $root,
            'asideName' => $root->name,
            'similar' => $similar,
        ]);
    }

    public function search() {
        $see = Request::get('see', 'all');
        $products_inst = Product::query();
        if ($s = Request::get('search')) {
            $products_inst->where(function ($query) use ($s) {
                /** @var QueryBuilder $query */
                //сначала ищем точное совпадение с началом названия товара
                return $query->orWhere('name', 'LIKE',  $s . '%');
            });

            if (Request::ajax()) {
                //если нашлось больше 10 товаров, показываем их
                if($products_inst->count() >= 10) {
                    $products = $products_inst->limit(10)->get()->transform(function ($item) {
                        return [
                            'name' => $item->name . ' [' . $item->article . ']',
                            'url' => $item->url
                        ];
                    });
                } else {
                    //если меньше 10, разницу дополняем с совпадением по всему названию товара и артиклу
                    $count_before = $products_inst->count();
                    $sub = 10 - $count_before;
                    $adds_query = Product::query()
                        ->orWhere('name', 'LIKE', '%' . str_replace(' ', '%', $s) . '%')
                        ->orWhere('article', 'LIKE', '%' . str_replace(' ', '%', $s) . '%');
                    $adds_prod = $adds_query->limit($sub)->get();
                    $prods_before = $products_inst->limit($count_before)->get();
                    $all_prods = $prods_before->merge($adds_prod);
                    $products = $all_prods->transform(function ($item) {
                        return [
                            'name' => $item->name . ' [' . $item->article . ']',
                            'url' => $item->url
                        ];
                    });
                }
                return ['data' => $products];
            }

            if ($see == 'all' || !is_numeric($see)) {
                $products = $products_inst->paginate(Settings::get('search_per_page'));
            } else {
                $products = $products_inst->paginate($see);
                $filter_query = Request::only(['see', 'price', 'in_stock']);
                $filter_query = array_filter($filter_query);
                $products->appends($filter_query);
            }
        } else {
            $products = collect();
        }


        return view('search.index', [
            'items' => $products,
            'title' => 'Результат поиска «' . $s . '»',
            'query' => $see,
            'name' => 'Поиск ' . $s,
            'keywords' => 'Поиск',
            'description' => 'Поиск',
        ]);
    }

}
