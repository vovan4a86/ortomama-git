<?php namespace App\Http\Controllers;

use App;
use Fanky\Admin\Models\Complex;
use Fanky\Admin\Models\NewsTag;
use Fanky\Admin\Models\ObjectItem;
use Fanky\Admin\Models\Page;
//use Request;
use Illuminate\Http\Request;
use Settings;
use View;

class ObjectsController extends Controller {
	public $bread = [];
	protected $object_page;

	public function __construct() {
		$this->object_page = Page::whereAlias('objects')
			->get()
			->first();
		$this->bread[] = [
			'url'  => '/'.$this->object_page['alias'],
			'name' => $this->object_page['name']
		];
	}

	public function index(Request $request) {
		$page = $this->object_page;
		if (!$page)
			abort(404, 'Страница не найдена');
		$bread = $this->bread;
        $page->ogGenerate();
        $page->setSeo();
        $items = ObjectItem::orderBy('date', 'desc')
            ->public()->paginate(Settings::get('complex_per_page') ?: 6);

        //обработка ajax-обращений, в routes добавить POST метод(!)
        if ($request->ajax()) {
            $view_items = [];
            foreach ($items as $item) {
                //добавляем новые элементы
                $view_items[] = view('objects.list_item', [
                    'item' => $item,
                ])->render();
            }

            return [
                'items'      => $view_items,
                'paginate' => view('paginations.links_limit', ['paginator' => $items])->render()
            ];
        }

        if (count($request->query())) {
            View::share('canonical', $this->object_page->alias);
        }

        return view('objects.index', [
            'title' => $page->title,
            'text' => $page->text,
            'h1'    => $page->getH1(),
            'bread' => $bread,
            'items' => $items,
        ]);
	}

	public function item($alias) {
		$item = ObjectItem::whereAlias($alias)->public()->first();
		if (!$item) abort(404);
		$bread = $this->bread;

		$bread[] = [
			'url'  => $item->url,
			'name' => $item->name
		];

		return view('objects.item', [
			'item'        => $item,
            'date'        => $item->dateFormat('d F Y'),
			'h1'          => $item->name,
			'name'        => $item->name,
			'text'        => $item->text,
			'images'        => $item->images,
			'bread'       => $bread,
			'title'       => $item->title,
			'keywords'    => $item->keywords,
			'description' => $item->description,
            'headerIsWhite' => true
		]);
	}
}
