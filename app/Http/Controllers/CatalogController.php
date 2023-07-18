<?php namespace App\Http\Controllers;

use Cache;
use Cookie;
use Doctrine\DBAL\Query\QueryBuilder;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\City;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Settings;
use Fanky\Auth\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Response;
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
        $page = Page::where('alias', 'catalog')->first();
        if (!$page) return abort(404);
        $bread = $page->getBread();
        $page->h1 = $page->getH1();
        $page->setSeo();

//        $per_page = Request::get('per_page', 6);
//        $per_page = is_numeric($per_page) ? $per_page : \Settings::get('product_per_page');
        if (!$per_page = session('per_page')) {
            $per_page = 6;
            session(['per_page' => $per_page]);
        }

        $categories = Catalog::getTopLevelOnList();
        $products = Product::public()->paginate($per_page);
        $products_count = Product::public()->count();

        return view('catalog.index', [
            'h1' => $page->h1,
            'text' => $page->text,
            'title' => $page->title,
            'bread' => $bread,
            'categories' => $categories,
            'products' => $products,
            'products_count' => $products_count,
            'per_page' => $per_page
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

        Auth::init();
        if (Auth::user() && Auth::user()->isAdmin) {
            View::share('admin_edit_link', route('admin.catalog.catalogEdit', [$category->id]));
        }
        if (!$per_page = session('per_page')) {
            $per_page = 6;
            session(['per_page' => $per_page]);
        }
        $products = Product::where('catalog_id', $category->id)->public()->paginate($per_page);
        $products_count = $category->products->count();

        $data = [
            'bread' => $bread,
            'category' => $category,
            'canonical' => $canonical,
            'h1' => $category->getH1(),
            'products' => $products,
            'products_count' => $products_count,
            'per_page' => $per_page
        ];

        if (Request::ajax()) {
            $view_items = [];
            foreach ($products as $item) {
                $view_items[] = view('catalog.product_item', [
                    'item' => $item,
                    'category' => $category,
                ])->render();
            }

            return response()->json([
                'items' => $view_items,
                'paginate' => view('catalog.section_pagination', [
                    'paginator' => $products,
                ])->render(),
            ]);
        }

        return view('catalog.category', $data);
    }

    public function product(Product $product) {
        $bread = $product->getBread();
        $product->generateTitle();
        $product->generateDescription();
        $product->generateText();
        $product->setSeo();
        $categories = Catalog::getTopLevelOnList();

        //наличие в корзине
        $in_cart = false;
        if (Session::get('cart')) {
            $cart = array_keys(Session::get('cart'));
            if ($cart) {
                $in_cart = in_array($product->id, $cart);
            }
        }

        $viewed = Session::get('viewed', []);
        if(!in_array($product->id, $viewed)) {
            Session::push('viewed', $product->id);
        }

        $viewed_products = [];
        if (count($viewed)) {
            foreach ($viewed as $i => $id) {
                $viewed_products[] = Product::find($id);
            }
        }

        $images = $product->images;
        $sizes = $product->sizes;
        $chars = $product->chars;


        Auth::init();
        if (Auth::user() && Auth::user()->isAdmin) {
            View::share('admin_edit_link', route('admin.catalog.productEdit', [$product->id]));
        }

        return view('catalog.product', [
            'product' => $product,
            'categories' => $categories,
            'in_cart' => $in_cart,
            'bread' => $bread,
            'images' => $images,
            'sizes' => $sizes,
            'chars' => $chars,
            'viewed_products' => $viewed_products
        ]);
    }

    public function search() {
        $see = Request::get('see', 'all');
        $products_inst = Product::query();
        if (!$per_page = session('per_page')) {
            $per_page = 6;
            session(['per_page' => $per_page]);
        }
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
        $products_count = $products_inst->count();

        return view('search.index', [
            'products' => $products,
            'h1' => 'Результат поиска «' . $s . '»',
            'query' => $see,
            'name' => 'Поиск ' . $s,
            'keywords' => 'Поиск',
            'description' => 'Поиск',
            'products_count' => $products_count,
            'per_page' => $per_page,
        ]);
    }

}
