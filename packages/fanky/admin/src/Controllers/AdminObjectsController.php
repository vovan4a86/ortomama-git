<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\ObjectImage;
use Fanky\Admin\Models\ObjectItem;
use Fanky\Admin\Settings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Request;
use Validator;
use Text;
use Thumb;
use Image;

class AdminObjectsController extends AdminController {

	public function getIndex() {
		$objects = ObjectItem::orderBy('date', 'desc')->paginate(100);

		return view('admin::objects.main', ['objects' => $objects]);
	}

	public function getEdit($id = null) {
		if (!$id || !($object = ObjectItem::find($id))) {
            $object = new ObjectItem;
            $object->date = date('Y-m-d');
            $object->published = 1;
		}

		return view('admin::objects.edit', ['object' => $object]);
	}

	public function postSave() {
		$id = Request::input('id');
		$data = Request::only(['date', 'name', 'announce', 'text', 'published',
                                'alias', 'title', 'keywords', 'description', 'city', 'square']);
		$image = Request::file('image');

		if (!array_get($data, 'alias')) $data['alias'] = Text::translit($data['name']);
		if (!array_get($data, 'title')) $data['title'] = $data['name'];
		if (!array_get($data, 'published')) $data['published'] = 0;

		// валидация данных
		$validator = Validator::make(
			$data,[
				'name' => 'required',
				'date' => 'required',
			]);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// Загружаем изображение
		if ($image) {
			$file_name = ObjectItem::uploadImage($image);
			$data['image'] = $file_name;
		}

		// сохраняем страницу
        $object = ObjectItem::find($id);
		$redirect = false;
		if (!$object) {
            $object = ObjectItem::create($data);
			$redirect = true;
		} else {
			if ($object->image && isset($data['image'])) {
                $object->deleteImage();
			}
            $object->update($data);
		}
//		$article->tags()->sync($tags);

		if($redirect){
			return ['redirect' => route('admin.objects.edit', [$object->id])];
		} else {
			return ['msg' => 'Изменения сохранены.'];
		}

	}

	public function postDelete($id) {
        $object = ObjectItem::find($id);
        $object->delete();

		return ['success' => true];
	}

	public function postDeleteImage($id) {
        $object = ObjectItem::find($id);
		if(!$object) return ['error' => 'object_not_found'];

        $object->deleteImage();
        $object->update(['image' => null]);

		return ['success' => true];
	}

    public function postProductImageUpload($id): array {
        $images = Request::file('images');
        $items = [];
        if ($images) foreach ($images as $image) {
            $file_name = ObjectImage::uploadImage($image);
            $order = ObjectImage::where('object_id', $id)->max('order') + 1;
            $item = ObjectImage::create(['object_id' => $id, 'image' => $file_name, 'order' => $order]);
            $items[] = $item;
        }

        $html = '';
        foreach ($items as $item) {
            $html .= view('admin::objects.object_image', ['image' => $item, 'active' => '']);
        }

        return ['html' => $html];
    }

    public function postImageEdit($id) {
        $image = ObjectImage::findOrFail($id);
        return view('admin::objects.object_image_edit', ['image' => $image]);
    }

    public function postImageDataSave($id) {
        $image = ObjectImage::findOrFail($id);
        $data = Request::only('name');
        $image->name = $data['name'];
        $image->save();
        return ['success' => true];
    }

    public function postProductImageOrder(): array {
        $sorted = Request::get('sorted', []);
        foreach ($sorted as $order => $id) {
            ObjectImage::whereId($id)->update(['order' => $order]);
        }

        return ['success' => true];
    }

    public function postUpdateImgOrder($id): array {
        $order = Request::get('order');
        ObjectImage::whereId($id)->update(['order' => $order]);

        return ['success' => true];
    }

    public function postDelImg($img_id): array {
        $img = ObjectImage::findOrFail($img_id);
        $img->delete();

        return ['success' => true];
    }

    public function postReorder() {
        $sorted = Request::input('sorted', []);
        foreach ($sorted as $order => $id) {
            DB::table('object_images')->where('id', $id)->update(array('order' => $order));
        }
        return ['success' => true];
    }


}
