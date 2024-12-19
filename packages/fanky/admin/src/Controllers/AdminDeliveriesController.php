<?php namespace Fanky\Admin\Controllers;

use DB;
use Fanky\Admin\Models\Delivery;
use Request;
use Validator;

class AdminDeliveriesController extends AdminController {

	public function getIndex() {
		$items = Delivery::orderBy('order')->get();

		return view('admin::deliveries.main', ['items' => $items]);
	}

	public function getEdit($id = null) {
		$item = Delivery::findOrNew($id);
		return view('admin::deliveries.edit', ['item' => $item]);
	}

	public function postSave() {
		$id = Request::input('id');
		$data = Request::only(['name', 'order']);

        // валидация данных
		$validator = Validator::make($data, [
				'name' => 'required',
			]);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

        // сохраняем страницу
		$item = Delivery::find($id);
		$redirect = false;
		if (!$item) {
            $data['order'] = Delivery::all()->max('order') + 1;
            $item = Delivery::create($data);
			$redirect = true;
		} else {
            $item->update($data);
		}

        if ($redirect) {
            return ['redirect' => route('admin.deliveries.edit', [$item->id])];
        } else {
            return ['success' => true, 'msg' => 'Изменения сохранены'];
        }
	}

	public function postDelete($id) {
        $item = Delivery::find($id);
        $item->delete();

		return ['success' => true];
	}

    public function postReorder(): array
    {
        $sorted = Request::input('sorted', []);
        foreach ($sorted as $order => $id) {
            DB::table('deliveries')->where('id', $id)
                ->update(array('order' => $order));
        }
        return ['success' => true];
    }
}
