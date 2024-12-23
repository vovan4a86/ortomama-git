<?php namespace App\Http\Controllers;

use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Point;
use Request;
use Settings;
use View;

class PointsController extends Controller {
	public $bread = [];
	protected $points_page;

	public function __construct() {
		$this->points_page = Page::whereAlias('points')
			->get()
			->first();
		$this->bread[] = [
			'url'  => $this->points_page['url'],
			'name' => $this->points_page['name']
		];
	}

	public function index() {
		$page = $this->points_page;
        $page->setSeo();

        if (!$page)
			abort(404, 'Страница не найдена');
		$bread = $this->bread;

        $points = Point::orderBy('order')->get();

        return view('points.index', [
            'bread' => $bread,
            'points' => $points,
            'text' => $page->text,
            'h1' => $page->getH1()
        ]);
	}

}
