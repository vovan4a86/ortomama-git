<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\Type;
use Request;
use Validator;
use DB;

class AdminTypesController extends AdminController {

	public function getIndex()
	{
		$types = Type::orderBy('order')->get();

		return view('admin::types.main', ['types' => $types]);
	}

	public function getEdit($id = null)
	{
		if (!$id || !($type = Type::findOrFail($id))) {
			$type = new Type;
		}

		return view('admin::types.edit', ['type' => $type]);
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
		$type = Type::find($id);
        $redirect = false;
		if (!$type) {
			$data['order'] = Type::max('order') + 1;
			$type = Type::create($data);
            $redirect = true;
		} else {
            $type->update($data);
		}
        if ($redirect) {
            return ['redirect' => route('admin.types.edit', [$type->id])];
        } else {
            return ['success' => true, 'msg' => 'Изменения сохранены'];
        }
	}

	public function postReorder(): array
    {
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('types')->where('id', $id)
                ->update(array('order' => $order));
		}
		return ['success' => true];
	}

	public function postDelete($id): array
    {
		$type = Type::find($id);
		$type->delete();

		return ['success' => true];
	}
}
