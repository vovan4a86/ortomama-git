<?php namespace App\Http\Controllers;

use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\MaterialImage;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\Action1;
use Fanky\Admin\Models\ActionProduct1;
use SEOMeta;
use View;
use Request;

class ActionController extends Controller {

    public function index() {
        $page = Page::getByPath(['actions']);
        if(!$page) return abort(404);
        $bread = $page->getBread();
        $page->h1 = $page->getH1();
        $page->setSeo();
        $actions = Action1::getTopLevel();
        $bgcolor = [
            'stock-item--accent',
            'stock-item--darken',
            ];

        return view('actions.index', [
            'h1'         => $page->h1,
            'text'       => $page->text,
            'title'      => $page->title,
            'bread'      => $bread,
            'actions' => $actions,
            'bgcolor'    => $bgcolor,
        ]);
    }

    public function view($alias) {
        $path = explode('/', $alias);
        /* проверка на продукт в категории */
        $product = null;
        $end = array_pop($path);
        $action = Action1::getByPath($path);
        if($action && $action->published) {
            $product = ActionProduct1::whereAlias($end)
                ->public()
                ->whereCatalogId($action->id)
                ->first();
        }
        if($product) {
            return $this->product($product);
        } else {
            array_push($path, $end);

            return $this->action($path + [$end]);
        }
    }

    public function action($path) {
        /** @var Action1 $action */
        $action = Action1::getByPath($path);
        if(!$action || !$action->published) abort(404, 'Страница не найдена');
        $bread = $action->getBread();
        $children = $action->public_children;
        $action->setSeo();

//        $test = Product::find(9);
//        $cat = $test->findRootParentName($test->catalog_id);
//        dd($cat);

        $products = $action->getProducts()->groupBy('catalog_id');
//        $products = $action->action_products();
//        $sort_products = [];
//        foreach ($products as $cat_id => $value) {
//            $cat_name = Product::findRootParentName($cat_id);
//            $sort_products[$cat_name] = $value;
//        }

        $collection = [];
        foreach ($products as $cat_id => $value) {
            $cat_name = Product::findRootParentName($cat_id);
            $i = 0;
            foreach ($value as $item) {
                $collection[$cat_name][$i] = Product::find($item->product_id);
                $i++;
            }
        }

//        dd($collection);

        return view('actions.action', [
            'bread'    => $bread,
            'action' => $action,
            'children' => $children,
            'h1'       => $action->getH1(),
            'action_products' => $collection,
        ]);
    }

    public function product(ActionProduct1 $product) {
        $bread = $product->getBread();
//		$related = $product->related()->public()->with('catalog')->get();
        $product->setSeo();
//        $params = $product->params()
//            ->where('group', '!=', '')
//            ->get()
//            ->groupBy('group');

        return view('services.product', [
            'product'    => $product,
            'bread'      => $bread,
            'name'       => $product->name,
//            'specParams' => $product->params_on_spec,
//            'params'     => $params,
        ]);
    }

}
