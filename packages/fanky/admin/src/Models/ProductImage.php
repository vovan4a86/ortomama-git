<?php namespace Fanky\Admin\Models;

use App\Traits\HasImage;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Thumb;

/**
 * Fanky\Admin\Models\ProductImage
 *
 * @property int        $id
 * @property int        $product_id
 * @property string     $image
 * @property int        $order
 * @property-read mixed $src
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\ProductImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\ProductImage whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\ProductImage whereProductId($value)
 * @mixin Eloquent
 * @property-read mixed $image_src
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\ProductImage query()
 */
class ProductImage extends Model {

	use HasImage;
	protected $table = 'product_images';

	protected $fillable = ['product_id', 'image', 'order'];

	public $timestamps = false;

	const UPLOAD_URL = '/uploads/products/';

	public static $thumbs = [
		1 => '100x100|fit', //admin product_list
		2 => '334x205|fit', //list item
		3 => '316x316|fit', //product_page
		4 => '200x200|fit', //index_cats_image
	];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getImageSrcAttribute()
    {
        return self::UPLOAD_URL . $this->image;
    }
}
