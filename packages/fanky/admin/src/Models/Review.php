<?php namespace Fanky\Admin\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Fanky\Admin\YouTube;

/**
 * Fanky\Admin\Models\Review
 *
 * @property int $id
 * @property string $type
 * @property string|null $text
 * @property string $adress
 * @property string $video
 * @property int $on_main
 * @property int $order
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $type_name
 * @property-read mixed $video_src
 * @property-read mixed $video_thumb
 * @property-read mixed $video_url
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Review onMain()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Review whereAdress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Review whereOnMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Review whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Review whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Review whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Review whereVideo($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Review query()
 */
class Review extends Model {

    use HasImage;

    public static $thumbs = [
        1 => '124x124|fit',
    ];

    const UPLOAD_URL = '/uploads/reviews/';
    const NO_IMAGE = '/static/images/common/woman-2.png';

    protected $table = 'reviews';

	protected $fillable = ['name', 'text', 'image', 'on_main', 'order', 'published'];

    public function scopePublic($query) {
        return $query->where('published', 1);
    }

    public function scopeOnMain($query)
	{
		return $query->where('on_main', 1);
	}

	public function getTypeNameAttribute($value)
	{
		return array_get(self::$types, $this->type);
	}

	public function getVideoSrcAttribute($value)
	{
		return $this->video ? YouTube::src($this->video) : null;
	}

	public function getVideoUrlAttribute($value)
	{
		return $this->video ? YouTube::url($this->video) : null;
	}

	public function getVideoThumbAttribute($value)
	{
		return $this->video ? YouTube::thumb($this->video) : null;
	}
}
