<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\Color;
use Request;
use Validator;
use DB;

class AdminColorsController extends AdminController {

	public function getIndex()
	{
		$colors = Color::orderBy('order')->get();

		return view('admin::colors.main', ['colors' => $colors]);
	}

	public function getEdit($id = null)
	{
		if (!$id || !($color = Color::findOrFail($id))) {
			$color = new Color;
		}

		return view('admin::colors.edit', ['color' => $color]);
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
		$color = Color::find($id);
        $redirect = false;
		if (!$color) {
			$data['order'] = Color::max('order') + 1;
			$color = Color::create($data);
            $redirect = true;
		} else {
            $color->update($data);
		}
        if ($redirect) {
            return ['redirect' => route('admin.colors.edit', [$color->id])];
        } else {
            return ['success' => true, 'msg' => 'Изменения сохранены'];
        }
	}

	public function postReorder(): array
    {
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('colors')->where('id', $id)
                ->update(array('order' => $order));
		}
		return ['success' => true];
	}

	public function postDelete($id): array
    {
		$color = Color::find($id);
        if (!$color->product) {
            $color->delete();
            return ['success' => true];
        } else {
            return ['success' => false, 'msg' => 'Нельзя удалить цвет, если он принадлежит одному из товаров.'];
        }
    }
}
