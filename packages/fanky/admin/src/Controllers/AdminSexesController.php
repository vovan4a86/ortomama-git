<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\Sex;
use Request;
use Validator;
use DB;

class AdminSexesController extends AdminController {

	public function getIndex()
	{
		$sexes = Sex::orderBy('order')->get();

		return view('admin::sexes.main', ['sexes' => $sexes]);
	}

	public function getEdit($id = null)
	{
		if (!$id || !($sex = Sex::findOrFail($id))) {
			$sex = new Sex;
		}

		return view('admin::sexes.edit', ['sex' => $sex]);
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
		$sex = Sex::find($id);
        $redirect = false;
		if (!$sex) {
			$data['order'] = Sex::max('order') + 1;
			$sex = Sex::create($data);
            $redirect = true;
		} else {
            $sex->update($data);
		}
        if ($redirect) {
            return ['redirect' => route('admin.sexes.edit', [$sex->id])];
        } else {
            return ['success' => true, 'msg' => 'Изменения сохранены'];
        }
	}

	public function postReorder(): array
    {
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('sexes')->where('id', $id)
                ->update(array('order' => $order));
		}
		return ['success' => true];
	}

	public function postDelete($id): array
    {
		$sex = Sex::find($id);
		$sex->delete();

		return ['success' => true];
	}
}
