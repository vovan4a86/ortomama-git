<?php namespace App\Http\Controllers;

use Doctrine\DBAL\Query\QueryBuilder;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\SearchIndex;
use Fanky\Admin\Settings;
use Fanky\Auth\Auth;
use SEOMeta;
use Session;
use Request;
use View;

class CatalogController extends Controller {

    public function index() {
        $page = Page::where('alias', 'catalog')->first();
        if (!$page) return abort(404);
        $bread = $page->getBread();
        $page->h1 = $page->getH1();
        $page->setSeo();

        if (!$per_page = session('per_page')) {
            $per_page = 6;
            session(['per_page' => $per_page]);
        }

        $categories = Catalog::getTopLevelOnList();

        $filter_data = request()->except(['page', 'brand']);
        $filter_brand = request()->only('brand');

        $appends = [];
        $query = SearchIndex::query();
        if(count($filter_data) || count($filter_brand)) {
            if($filter_brand) {
                $query = $query->whereIn('brand', $filter_brand['brand']);
                $appends[] = ['brand' => $filter_brand];
            }

            foreach ($filter_data as $name => $values) {
                $query = $query->whereJsonContains($name, $values);
                $appends[] = [$name => $values];
            }

            $products_ids = $query->pluck('product_id')->all();

            $products = Product::public()
                ->whereIn('id', $products_ids)
                ->with(['brand', 'catalog', 'single_image'])
                ->paginate($per_page)
                ->appends($appends);
            $products_count = count($products);
        } else {
            $products = Product::public()
                ->with(['brand', 'catalog', 'single_image'])
                ->paginate($per_page);
            $products_count = Product::public()->count();
        }

        return view('catalog.index', [
            'h1' => $page->h1,
            'text' => $page->text,
            'title' => $page->title,
            'bread' => $bread,
            'categories' => $categories,
            'products' => $products ?? [],
            'products_count' => $products_count ?? 0,
            'per_page' => $per_page,
            'filter_data' => $filter_data,
            'filter_brand' => $filter_brand ? $filter_brand['brand'] : []
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

        $category->load('parent');

        Auth::init();
        if (Auth::user() && Auth::user()->isAdmin) {
            View::share('admin_edit_link', route('admin.catalog.catalogEdit', [$category->id]));
        }
        if (!$per_page = session('per_page')) {
            $per_page = 6;
            session(['per_page' => $per_page]);
        }

        $filter_data = request()->except(['page', 'brand']);
        $filter_brand = request()->only('brand');

        $query = SearchIndex::query();
        if($filter_brand) {
            $query = $query->whereIn('brand', $filter_brand);
        }

        foreach ($filter_data as $name => $values) {
            $query = $query->whereIn($name, $values);
        }

        $products_ids = $query->pluck('product_id')->all();
        $children_ids = $this->getChildrenIds($category);

        $products = Product::whereIn('catalog_id', $children_ids)
            ->whereIn('id', $products_ids)
            ->public()
            ->with(['single_image', 'catalog', 'brand'])
            ->paginate($per_page);
        $products_count = $category->products->count();

        $data = [
            'bread' => $bread,
            'category' => $category,
            'canonical' => $canonical,
            'h1' => $category->getH1(),
            'products' => $products,
            'products_count' => $products_count,
            'per_page' => $per_page,
            'filter_data' => $filter_data,
            'filter_brand' => $filter_brand,
            'filer_sizes' => $filter_data['sizes'] ?? []
        ];

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

    public function getChildrenIds(Catalog $category) {
        $children_ids = [];
        if (count($category->children)) {
            $children_ids = $category->getRecurseChildrenIds();
        }
        if (!in_array($category->id, $children_ids)) {
            $children_ids[] = $category->id;
        }

        return $children_ids;
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
