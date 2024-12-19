<?php namespace Fanky\Admin\Controllers;

use DB;
use Fanky\Admin\Models\Payment;
use Request;
use Validator;
use Text;

class AdminPaymentsController extends AdminController {

	public function getIndex() {
		$items = Payment::orderBy('order')->get();

		return view('admin::payments.main', ['items' => $items]);
	}

	public function getEdit($id = null) {
		$item = Payment::findOrNew($id);
		return view('admin::payments.edit', ['item' => $item]);
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
		$item = Payment::find($id);
		$redirect = false;
		if (!$item) {
            $data['order'] = Payment::all()->max('order') + 1;
            $item = Payment::create($data);
			$redirect = true;
		} else {
            $item->update($data);
		}

        if ($redirect) {
            return ['redirect' => route('admin.payments.edit', [$item->id])];
        } else {
            return ['success' => true, 'msg' => 'Изменения сохранены'];
        }
	}

	public function postDelete($id) {
        $item = Payment::find($id);
        $item->delete();

		return ['success' => true];
	}

    public function postReorder(): array
    {
        $sorted = Request::input('sorted', []);
        foreach ($sorted as $order => $id) {
            DB::table('payments')->where('id', $id)
                ->update(array('order' => $order));
        }
        return ['success' => true];
    }
}
