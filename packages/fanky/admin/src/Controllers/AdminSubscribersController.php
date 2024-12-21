<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\Subscriber;
use Request;
use Validator;

class AdminSubscribersController extends AdminController {

	public function getIndex() {
		$subscribers = Subscriber::orderBy('created_at', 'desc')->paginate(30);
		return view('admin::subscribers.main', [
			'subscribers'	=> $subscribers
		]);
	}

    public function getEdit($id = null)
    {
        if (!$id || !($subscriber = Subscriber::findOrFail($id))) {
            $subscriber = new Subscriber;
        }

        return view('admin::subscribers.edit', ['subscriber' => $subscriber]);
    }

    public function postSave(): array
    {
        $id = Request::input('id');
        $data = Request::only(['email']);

        // валидация данных
        $validator = Validator::make(
            $data,
            [
                'email' => 'required'
            ]
        );
        if ($validator->fails()) {
            return ['errors' => $validator->messages()];
        }

        // сохраняем страницу
        $subscriber = Subscriber::find($id);
        $redirect = false;
        if (!$subscriber) {
            $subscriber = Subscriber::create($data);
            $redirect = true;
        } else {
            $subscriber->update($data);
        }
        if ($redirect) {
            return ['redirect' => route('admin.subscribers.edit', [$subscriber->id])];
        } else {
            return ['success' => true, 'msg' => 'Изменения сохранены'];
        }
    }

    public function postDelete($id): array
    {
        $subscriber = Subscriber::find($id);
        $subscriber->delete();

        return ['success' => true];
    }

}
