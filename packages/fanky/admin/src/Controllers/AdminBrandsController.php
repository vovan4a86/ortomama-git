<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\Brand;
use Request;
use Validator;
use DB;

class AdminBrandsController extends AdminController {

	public function getIndex()
	{
		$brands = Brand::orderBy('order')->get();

		return view('admin::brands.main', ['brands' => $brands]);
	}

	public function getEdit($id = null)
	{
		if (!$id || !($brand = Brand::findOrFail($id))) {
			$brand = new Brand;
		}

		return view('admin::brands.edit', ['brand' => $brand]);
	}

	public function postSave(): array
    {
		$id = Request::input('id');
		$data = Request::only(['name', 'order']);

		// валидация данных
		$validator = Validator::make(
		    $data,
		    [
		    	'name' => 'required'
		    ]
		);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// сохраняем страницу
		$brand = Brand::find($id);
        $redirect = false;
		if (!$brand) {
			$data['order'] = Brand::max('order') + 1;
			$brand = Brand::create($data);
            $redirect = true;
		} else {
            $brand->update($data);
		}
        if ($redirect) {
            return ['redirect' => route('admin.brands.edit', [$brand->id])];
        } else {
            return ['success' => true, 'msg' => 'Изменения сохранены'];
        }
	}

	public function postReorder(): array
    {
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('brands')->where('id', $id)
                ->update(array('order' => $order));
		}
		return ['success' => true];
	}

	public function postDelete($id): array
    {
		$brand = Brand::find($id);
		$brand->delete();

		return ['success' => true];
	}
}
