<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\Size;
use Request;
use Validator;
use DB;

class AdminSizesController extends AdminController {

	public function getIndex()
	{
		$sizes = Size::orderBy('value')->get();

		return view('admin::sizes.main', ['sizes' => $sizes]);
	}

	public function getEdit($id = null)
	{
		if (!$id || !($size = Size::findOrFail($id))) {
			$size = new Size;
		}

		return view('admin::sizes.edit', ['size' => $size]);
	}

	public function postSave(): array
    {
		$id = Request::input('id');
		$data = Request::only(['value']);

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
		$size = Size::find($id);
        $redirect = false;
		if (!$size) {
//			$data['order'] = Size::max('order') + 1;
			$size = Size::create($data);
            $redirect = true;
		} else {
            $size->update($data);
		}
        if ($redirect) {
            return ['redirect' => route('admin.sizes.edit', [$size->id])];
        } else {
            return ['success' => true, 'msg' => 'Изменения сохранены'];
        }
	}

	public function postReorder(): array
    {
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('sizes')->where('id', $id)
                ->update(array('order' => $order));
		}
		return ['success' => true];
	}

	public function postDelete($id): array
    {
		$size = Size::find($id);
		$size->delete();

		return ['success' => true];
	}
}
