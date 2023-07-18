<?php
namespace Fanky\Admin\Controllers;

use DB;
use Fanky\Admin\Models\Point;
use Request;
use Validator;
use Text;

class AdminPointsController extends AdminController
{

    public function getIndex()
    {
        $points = Point::orderBy('order', 'asc')->get();

        return view('admin::points.main', ['points' => $points]);
    }

    public function getEdit($id = null)
    {
        $item = Point::findOrNew($id);
        return view('admin::points.edit', ['item' => $item]);
    }

    public function postSave()
    {
        $id = Request::input('id');
        $data = Request::only(['name', 'phone', 'address', 'longitude', 'latitude', 'order']);
//        if(!array_get($data, 'order')) $data['order'] = 0;

        // валидация данных
        $validator = Validator::make($data, [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return ['errors' => $validator->messages()];
        }

        // сохраняем страницу
        $item = Point::find($id);
        $redirect = false;
        if (!$item) {
            $data['order'] = Point::all()->max('order') + 1;
            Point::create($data);
            $redirect = true;
        } else {
            $item->update($data);
        }
        return $redirect
            ? ['redirect' => route('admin.points')]
            : ['success' => true, 'msg' => 'Изменения сохранены'];
//        return ['redirect' => route('admin.points')];
    }

    public function postDelete($id)
    {
        $item = Point::find($id);
        $item->delete();

        return ['success' => true];
    }

    public function postReorder()
    {
        $sorted = Request::input('sorted', []);
        foreach ($sorted as $order => $id) {
            DB::table('points')->where('id', $id)->update(array('order' => $order));
        }
        return ['success' => true];
    }

}
