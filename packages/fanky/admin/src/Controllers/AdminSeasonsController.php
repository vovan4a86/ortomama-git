<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\Season;
use Request;
use Validator;
use DB;

class AdminSeasonsController extends AdminController {

	public function getIndex()
	{
		$seasons = Season::orderBy('order')->get();

		return view('admin::seasons.main', ['seasons' => $seasons]);
	}

	public function getEdit($id = null)
	{
		if (!$id || !($season = Season::findOrFail($id))) {
			$season = new Season;
		}

		return view('admin::seasons.edit', ['season' => $season]);
	}

	public function postSave(): array
    {
		$id = Request::input('id');
		$data = Request::only(['value', 'order']);

		// валидация данных
		$validator = Validator::make(
		    $data,
		    [
		    	'value' => 'required'
		    ]
		);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// сохраняем страницу
		$season = Season::find($id);
        $redirect = false;
		if (!$season) {
			$data['order'] = Season::max('order') + 1;
			$season = Season::create($data);
            $redirect = true;
		} else {
            $season->update($data);
		}
        if ($redirect) {
            return ['redirect' => route('admin.seasons.edit', [$season->id])];
        } else {
            return ['success' => true, 'msg' => 'Изменения сохранены'];
        }
	}

	public function postReorder(): array
    {
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('seasons')->where('id', $id)
                ->update(array('order' => $order));
		}
		return ['success' => true];
	}

	public function postDelete($id): array
    {
		$season = Season::find($id);
		$season->delete();

		return ['success' => true];
	}
}
