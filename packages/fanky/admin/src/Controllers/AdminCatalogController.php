<?php
namespace Fanky\Admin\Controllers;

use App\Imports\ProductsImport;
use Carbon\Carbon;
use DB;
use Exception;
use Fanky\Admin\Models\AdminLog;
use Fanky\Admin\Models\Brand;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Category;
use Fanky\Admin\Models\Char;
use Fanky\Admin\Models\Color;
use Fanky\Admin\Models\Document;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\ProductImage;
use Fanky\Admin\Models\Season;
use Fanky\Admin\Models\Gender;
use Fanky\Admin\Models\Size;
use Fanky\Admin\Models\Type;
use Fanky\Admin\Pagination;
use Illuminate\Support\Facades\File;
use Request;
use Settings;
use Text;
use Validator;

class AdminCatalogController extends AdminController
{

    public function getIndex()
    {
        $catalogs = Catalog::orderBy('order')->get();

        $last_update = Carbon::createFromTimestamp(0);
        $last_update_file = resource_path('.last_update');
        if (File::exists($last_update_file)) {
            $last_update = Carbon::createFromTimestamp(File::lastModified($last_update_file));
        }
        $content = view(
            'admin::catalog.index',
            [
                'last_update' => $last_update
            ]
        );

        return view('admin::catalog.main', [
            'catalogs' => $catalogs,
            'content' => $content
        ]);
    }

    public function postProducts($catalog_id)
    {
        $catalog = Catalog::findOrFail($catalog_id);
        $products = Pagination::init($catalog->products()->orderBy('order'), 20)
            ->get();

        return view('admin::catalog.products', [
            'catalog' => $catalog,
            'products' => $products
        ]);
    }

    public function getProducts($catalog_id)
    {
        $catalogs = Catalog::orderBy('order')->get();

        return view('admin::catalog.main', [
            'catalogs' => $catalogs,
            'content' => $this->postProducts($catalog_id)
        ]);
    }

    public function getCatalogEdit($id = null)
    {
        $catalogs = Catalog::orderBy('order')->get();

        return view('admin::catalog.main', [
            'catalogs' => $catalogs,
            'content' => $this->postCatalogEdit($id)
        ]);
    }

    public function postCatalogEdit($id = null)
    {
        /** @var Catalog $catalog */
        if (!$id || !($catalog = Catalog::findOrFail($id))) {
            $catalog = new Catalog([
                'parent_id' => Request::get('parent'),
                'published' => 1
            ]);
        }
        $catalogs = Catalog::orderBy('order')
            ->where('id', '!=', $catalog->id)
            ->get();


        return view('admin::catalog.catalog_edit', [
            'catalog' => $catalog,
            'catalogs' => $catalogs
        ]);
    }

    public function postCatalogSave(): array
    {
        $id = Request::input('id');
        $data = Request::except(['id']);
        if (!array_get($data, 'alias')) {
            $data['alias'] = Text::translit($data['name']);
        }
        if (!array_get($data, 'title')) {
            $data['title'] = $data['name'];
        }
        if (!array_get($data, 'h1')) {
            $data['h1'] = $data['name'];
        }
        if (!array_get($data, 'on_main')) {
            $data['on_main'] = 0;
        }
        if (!array_get($data, 'on_menu')) {
            $data['on_menu'] = 0;
        }
        if (!array_get($data, 'on_footer_menu')) {
            $data['on_footer_menu'] = 0;
        }
        if (!array_get($data, 'discount_delivery')) {
            $data['discount_delivery'] = 0;
        }
        $image = Request::file('image');

        // валидация данных
        $validator = Validator::make(
            $data,
            [
                'name' => 'required',
            ]
        );
        if ($validator->fails()) {
            return ['errors' => $validator->messages()];
        }
        // Загружаем изображение
        if ($image) {
            $file_name = Catalog::uploadImage($image);
            $data['image'] = $file_name;
        }

        // сохраняем страницу
        $catalog = Catalog::find($id);
        $redirect = false;
        if (!$catalog) {
            $data['order'] = Catalog::where('parent_id', $data['parent_id'])->max('order') + 1;
            $catalog = Catalog::create($data);
            $redirect = true;
        } else {
            $catalog->update($data);
        }

        if ($redirect) {
            return ['redirect' => route('admin.catalog.catalogEdit', [$catalog->id])];
        } else {
            return ['success' => true, 'msg' => 'Изменения сохранены'];
        }
    }

    /**
     * @throws Exception
     */
    public function postCatalogDelete($id): array
    {
        $catalog = Catalog::findOrFail($id);
        $catalog->delete();

        return ['success' => true];
    }

    public function postCatalogReorder(): array
    {
        // изменение родителя
        $id = Request::input('id');
        $parent = Request::input('parent');
        DB::table('catalogs')->where('id', $id)->update(array('parent_id' => $parent));
        // сортировка
        $sorted = Request::input('sorted', []);
        foreach ($sorted as $order => $id) {
            DB::table('catalogs')->where('id', $id)->update(array('order' => $order));
        }

        return ['success' => true];
    }

    public function getProductEdit($catalog_id, $id = null)
    {
        $catalogs = Catalog::orderBy('order')->get();

        return view('admin::catalog.main', [
            'catalogs' => $catalogs,
            'content' => $this->postProductEdit($catalog_id, $id)
        ]);
    }

    public function postProductEdit($catalog_id, $id = null)
    {
        /** @var Product $product */
        if (!$id || !($product = Product::findOrFail($id))) {
            $product = new Product([
                'published' => 1,
                'brand_id' => 0,
                'in_stock' => 1,
//                'order' => Product::where('catalog_id', $catalog_id)->max('order') + 1
            ]);
        }

        $current_catalog = Catalog::find($catalog_id);
        $pinned_catalogs = $product->catalog ? $product->catalog->pluck('id')->all() : [];
        $catalogs = Catalog::getCatalogList();

        $brands = Brand::pluck('value', 'id')->all();
        $colors = Color::pluck('value', 'id')->all();

        $sizes = Size::all();
        $product_sizes = $product->sizes()->pluck('sizes.id')->all();
        $types = Type::all();
        $product_types = $product->types()->pluck('types.id')->all();
        $seasons = Season::query()->orderBy('order')->get();
        $product_seasons = $product->seasons()->pluck('seasons.id')->all();
        $genders = Gender::query()->orderBy('order')->get();
        $product_genders = $product->genders()->pluck('genders.id')->all();
        $cats = Category::query()->orderBy('order')->get();
        $product_cats = $product->categories()->pluck('categories.id')->all();

        $data = [
            'product' => $product,
            'catalogs' => $catalogs,
            'current_catalog' => $current_catalog,
            'brands' => $brands,
            'colors' => $colors,
            'sizes' => $sizes,
            'product_sizes' => $product_sizes,
            'types' => $types,
            'product_types' => $product_types,
            'seasons' => $seasons,
            'product_seasons' => $product_seasons,
            'genders' => $genders,
            'product_genders' => $product_genders,
            'cats' => $cats,
            'product_cats' => $product_cats,
            'pinned_catalogs' => $pinned_catalogs
        ];
        return view('admin::catalog.product_edit', $data);
    }

    public function postProductSave(): array
    {
        $id = Request::get('id');
        $data = Request::except(['id', 'sizes', 'types', 'chars', 'genders', 'seasons', 'catalog_id', 'selected_catalog_ids']);
        $sizes = Request::get('sizes');
        $types = Request::get('types');
        $genders = Request::get('genders');
        $seasons = Request::get('seasons');
        $cats = Request::get('cats');
        $catalog_id = Request::get('catalog_id');
        $selected_catalog_ids = Request::get('selected_catalog_ids');
        if(!isset($selected_catalog_ids[$catalog_id])) {
            $selected_catalog_ids[] = $catalog_id;
        }


        if (!array_get($data, 'published')) {
            $data['published'] = 0;
        }
        if (!array_get($data, 'alias')) {
            $data['alias'] = Text::translit($data['name']);
        }
        if (!array_get($data, 'title')) {
            $data['title'] = $data['name'];
        }
        if (!array_get($data, 'h1')) {
            $data['h1'] = $data['name'];
        }
        if (!array_get($data, 'fss')) {
            $data['fss'] = 0;
        }

        //сохраняем Характеристики
        $param_data = Request::get('chars', []);
        $param_ids = array_get($param_data, 'id', []);
        $param_names = array_get($param_data, 'name', []);
        $param_values = array_get($param_data, 'value', []);
        $params = [];
        foreach ($param_ids as $key => $param_id) {
            $params[] = [
                'id' => $param_id,
                'name' => trim(array_get($param_names, $key)),
                'value' => trim(array_get($param_values, $key)),
            ];
        }
        array_pop($params);

        $rules = [
            'name' => 'required',
            'size' => 'required'
        ];

        $rules['alias'] = $id
            ? 'required|unique:products,alias,' . $id . ',id'
            : 'required|unique:products,alias,null,id';
        // валидация данных
        $validator = Validator::make(
            $data,
            $rules
        );
        if ($validator->fails()) {
            return ['errors' => $validator->messages()];
        }
        $redirect = false;

        // сохраняем страницу
        $product = Product::find($id);
        if (!$product) {
            $data['order'] = Product::whereCatalogId($data['catalog_id'])->max('order') + 1;
            $product = Product::create($data);
            $redirect = true;
        } else {
            $product->update($data);
        }

        $product->catalog()->sync($selected_catalog_ids);
        $product->sizes()->sync($sizes);
        $product->types()->sync($types);
        $product->genders()->sync($genders);
        $product->seasons()->sync($seasons);
        $product->categories()->sync($cats);

        $start_update = Carbon::now();
        foreach ($params as $key => $char) {
            $p = Char::findOrNew(array_get($char, 'id'));
            if (!$p->id) {
                $redirect = false;
            }
            $char['product_id'] = $product->id;
            $char['order'] = $key;
            $char['updated_at'] = $start_update;
            $p->fill($char)->save();
        }
        Char::whereProductId($product->id)
            ->where('updated_at', '<', $start_update)
            ->delete();

        return $redirect
            ? [
                'redirect' => route('admin.catalog.productEdit', [
                    'catalog_id' => $product->catalog_id,
                    'id' => $product->id
                ])
            ]
            : ['success' => true, 'msg' => 'Изменения сохранены'];
    }

    public function postProductReorder(): array
    {
        $sorted = Request::input('sorted', []);
        foreach ($sorted as $order => $id) {
            DB::table('products')->where('id', $id)->update(array('order' => $order));
        }

        return ['success' => true];
    }

    public function postUpdateOrder($id): array
    {
        $order = Request::get('order');
        Product::whereId($id)->update(['order' => $order]);

        return ['success' => true];
    }

    public function postProductDelete($catalog_id, $id): array
    {
        $product = Product::whereCatalogId($catalog_id)->whereId($id)->first();
        if (count($product->images)) {
            foreach ($product->images as $item) {
                $item->deleteImage();
                $item->delete();
            }
        }
        $c = Catalog::find($catalog_id);
        $c->products()->detach($id);
        $product->delete();

        return ['success' => true];
    }

    public function postProductImageUpload($product_id): array
    {
        $product = Product::findOrFail($product_id);
        $images = Request::file('images');
        $items = [];
        if ($images) {
            foreach ($images as $image) {
                $file_name = ProductImage::uploadImage($image);
                $order = ProductImage::where('product_id', $product_id)->max('order') + 1;
                $item = ProductImage::create(['product_id' => $product_id, 'image' => $file_name, 'order' => $order]);
                $items[] = $item;
            }
        }

        $html = '';
        foreach ($items as $item) {
            $html .= view('admin::catalog.product_image', ['image' => $item, 'active' => '']);
        }

        return ['html' => $html];
    }

    public function postProductImageOrder(): array
    {
        $sorted = Request::get('sorted', []);
        foreach ($sorted as $order => $id) {
            ProductImage::whereId($id)->update(['order' => $order]);
        }

        return ['success' => true];
    }

    /**
     * @throws Exception
     */
    public function postProductImageDelete($id): array
    {
        /** @var ProductImage $item */
        $item = ProductImage::findOrFail($id);
        $item->deleteImage();
        $item->delete();

        return ['success' => true];
    }

    public function getGetCatalogs($id = 0): array
    {
        $catalogs = Catalog::whereParentId($id)->orderBy('order')->get();
        $result = [];
        foreach ($catalogs as $catalog) {
            $has_children = (bool)$catalog->children()->count();
            $result[] = [
                'id' => $catalog->id,
                'text' => $catalog->name,
                'children' => $has_children,
                'icon' => ($catalog->published) ? 'fa fa-eye text-green' : 'fa fa-eye-slash text-muted',
            ];
        }

        return $result;
    }

    public function postProductDocUpload($product_id): array
    {
        $docs = Request::file('docs');
        $items = [];
        if ($docs) {
            foreach ($docs as $doc) {
                $file_name = Document::uploadFile($doc);
                $order = Document::where('product_id', $product_id)->max('order') + 1;
                $item = Document::create(['product_id' => $product_id, 'src' => $file_name, 'order' => $order]);
                $items[] = $item;
            }
        }

        $html = '';
        foreach ($items as $item) {
            $html .= view('admin::catalog.product_doc', ['doc' => $item]);
        }

        return ['html' => $html];
    }

    public function postProductDocOrder(): array
    {
        $sorted = Request::get('sorted', []);
        foreach ($sorted as $order => $id) {
            Document::whereId($id)->update(['order' => $order]);
        }

        return ['success' => true];
    }

    public function postProductDocDelete($id): array
    {
        $item = Document::findOrFail($id);
        $item->deleteSrcFile();
        $item->delete();

        return ['success' => true];
    }

    public function postProductDocEdit($id)
    {
        $doc = Document::findOrFail($id);
        return view('admin::catalog.product_doc_edit', ['doc' => $doc]);
    }

    public function postProductDocDataSave($id)
    {
        $image = Document::findOrFail($id);
        $data = Request::only('name');
        $image->name = $data['name'];
        $image->save();
        return ['success' => true];
    }

    //export|import
//    public function getExportFile()
//    {
//        return response()
//            ->download('export/ortomama-price.xlsx', null, ['Cache-Control' => 'no-cache, must-revalidate']);
//    }

    public function postImportPrice()
    {
        $file = Request::file('price');
        $file_name = 'price.xlsx';
        $file->move(resource_path('/'), $file_name);
        AdminLog::add('Файл для обновления каталога загружен успешно. Ожидается обновление.');

        $catalogs = Catalog::orderBy('order')->get();
        $content = view('admin::catalog.upload_price')->render();
        return view('admin::catalog.main', ['catalogs' => $catalogs, 'content' => $content]);
    }

    public function postImportPriceNow()
    {
        $file = resource_path('price.xlsx');

        if (File::exists($file)) {
            $last_update = Carbon::createFromTimestamp(0);
            $last_update_file = resource_path('.last_update');
            if (File::exists($last_update_file)) {
                $last_update = Carbon::createFromTimestamp(File::get($last_update_file));
            }
            $file_modify = Carbon::createFromTimestamp(File::lastModified($file));
            if ($file_modify->greaterThan($last_update)) {
                AdminLog::$processLog = false;

                (new ProductsImport())->import($file);

                File::put($last_update_file, $file_modify->timestamp);

                $catalogs = Catalog::orderBy('order')->get();
                $content = view('admin::catalog.upload_price_done')->render();

                return view('admin::catalog.main', ['catalogs' => $catalogs, 'content' => $content]);
            }
        }
    }
}
