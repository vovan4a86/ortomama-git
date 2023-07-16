<?php namespace App\Http\Controllers;

use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Category;
use Fanky\Admin\Models\City;
use Fanky\Admin\Models\Page;
use SEOMeta;
use Settings;

class WelcomeController extends Controller {
    public function index() {
        /** @var Page $page */
        $page = Page::find(1);
        $page->ogGenerate();
        $page->setSeo();
        $cats_list = Category::query()->orderBy('order')->get();

        return response()->view('pages.index', [
            'page' => $page,
            'text' => $page->text,
            'h1' => $page->getH1(),
            'cats_list' => $cats_list
        ]);
    }
}
