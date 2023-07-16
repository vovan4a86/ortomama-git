<?php namespace Fanky\Admin\Controllers;

use Request;
use Validator;
use DB;
use Fanky\Admin\YouTube;
use Fanky\Admin\Models\Review;

class AdminReviewsController extends AdminController {

	public function getIndex()
	{
		$reviews = Review::orderBy('order')->get();

		return view('admin::reviews.main', ['reviews' => $reviews]);
	}

	public function getEdit($id = null)
	{
		if (!$id || !($review = Review::findOrFail($id))) {
			$review = new Review;
		}

		return view('admin::reviews.edit', ['review' => $review]);
	}

	public function postSave()
	{
		$id = Request::input('id');
		$data = Request::only(['name', 'text', 'order', 'on_main', 'published']);
		$image = Request::file('image');

		if (!$data['published']) $data['published'] = 0;
		if (!$data['on_main']) $data['on_main'] = 0;

		// валидация данных
		$validator = Validator::make(
		    $data,
		    [
		    	'name' => 'required',
		    	'text' => 'required',
		    ]
		);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

        if($image) {
            $file_name = Review::uploadImage($image);
            $data['image'] = $file_name;
        }

		// сохраняем страницу
		$review = Review::find($id);
        $redirect = false;
		if (!$review) {
			$data['order'] = Review::max('order') + 1;
			$review = Review::create($data);
            $redirect = true;
		} else {
            $review->update($data);
		}
        if ($redirect) {
            return ['redirect' => route('admin.reviews.edit', [$review->id])];
        } else {
            return ['success' => true, 'msg' => 'Изменения сохранены'];
        }
	}

	public function postReorder()
	{
		$sorted = Request::input('sorted', []);
		foreach ($sorted as $order => $id) {
			DB::table('reviews')->where('id', $id)->update(array('order' => $order));
		}
		return ['success' => true];
	}

	public function postDelete($id)
	{
		$review = Review::find($id);
		$review->delete();

		return ['success' => true];
	}
}
