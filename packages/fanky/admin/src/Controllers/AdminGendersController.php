<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\Gender;
use Request;
use Validator;
use DB;

class AdminGendersController extends AdminController {

	public function getIndex()
	{
		$sexes = Gender::orderBy('order')->get();

		return view('admin::genders.main', ['sexes' => $sexes]);
	}

	public function getEdit($id = null)
	{
		if (!$id || !($sex = Gender::findOrFail($id))) {
			$sex = new Gender;
		}

		return view('admin::genders.edit', ['sex' => $sex]);
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
		$sex = Gender::find($id);
        $redirect = false;
		if (!$sex) {
			$data['order'] = Gender::max('order') + 1;
			$sex = Gender::create($data);
            $redirect = true;
		} else {
            $sex->update($data);
		}
        if ($redirect) {
            return ['redirect' => route('admin.genders.edit', [$sex->id])];
        } else {
            return ['success' => true, 'msg' => 'Изменения сохранены'];
        }
	}

	public function postReorder(): array
    {
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('genders')->where('id', $id)
                ->update(array('order' => $order));
		}
		return ['success' => true];
	}

	public function postDelete($id): array
    {
		$sex = Gender::find($id);
		$sex->delete();

		return ['success' => true];
	}
}
