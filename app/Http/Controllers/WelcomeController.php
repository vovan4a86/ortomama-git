<?php namespace App\Http\Controllers;

use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Category;
use Fanky\Admin\Models\City;
use Fanky\Admin\Models\Page;
use S;
use SEOMeta;
use Settings;

class WelcomeController extends Controller {
    public function index() {
        /** @var Page $page */
        $page = Page::find(1);
        $page->ogGenerate();
        $page->setSeo();
        $cats_list = Category::query()
            ->with(['products', 'products.catalog', 'products.single_image'])
            ->orderBy('order')
            ->get();

        $main_slider = S::get('main_slider');
        $main_categories = S::get('main_categories');
        $main_features = S::get('main_features');
        $main_features_chunks = array_chunk($main_features, 3);
        $features_colors = ['green', 'orange', 'blue'];

        return response()->view('pages.index', [
            'page' => $page,
            'text' => $page->text,
            'h1' => $page->getH1(),
            'cats_list' => $cats_list,
            'main_slider' => $main_slider,
            'main_categories' => $main_categories,
            'main_features_chunks' => $main_features_chunks,
            'features_colors' => $features_colors
        ]);
    }
}
