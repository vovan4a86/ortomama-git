<?php namespace Fanky\Admin\Models;

use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Fanky\Admin\Models\SearchIndex
 *
 * @property int $product_id
 * @property array|null $sizes
 * @property array|null $seasons
 * @property string $brand
 * @property array|null $genders
 * @property array|null $types
 * @method static Builder|SearchIndex newModelQuery()
 * @method static Builder|SearchIndex newQuery()
 * @method static Builder|SearchIndex query()
 * @method static Builder|SearchIndex whereCreatedAt($value)
 * @method static Builder|SearchIndex whereName($value)
 * @method static Builder|SearchIndex whereText($value)
 * @method static Builder|SearchIndex whereUpdatedAt($value)
 * @method static Builder|SearchIndex whereUrl($value)
 * @mixin \Eloquent
 */
class SearchIndex extends Model {

	protected $primaryKey = null;
	protected $fillable = ['product_id','sizes', 'seasons', 'brand', 'genders', 'types'];
	public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'sizes' => 'array',
        'seasons' => 'array',
        'genders' => 'array',
        'types' => 'array'
    ];

	public function delete() {
		parent::delete();
	}

	public function getAnnounce($search) {
		$text = strip_tags($this->text);
		$text = str_replace(["\n", "\r", "\t"], '', $text);
		$pos = mb_stripos(Str::lower($text), Str::lower($search));
		if($pos === false){
			return $this->announce;
		} else {
			$start = max(0, $pos - 150);
			$length = Str::length($search) + 250;
			$substr = Str::substr($text, $start, $pos-$start) . '<b>';
			$substr .= Str::substr($text, $pos, Str::length($search)) . '</b>';
			$substr .= Str::substr($text, $pos + Str::length($search), 50);

			$substr = trim($substr);

			if($start > 0) $substr = '..' . $substr;
			if($pos + $length < Str::length($text)) $substr .= '..';
			return $substr;
		}
	}

	public static function update_index(): void
    {
		//clear_all;
		$item = new self();
		$table = $item->getTable();

		try{
			DB::beginTransaction();

			DB::table($table)->delete();

			$catalogs = Catalog::wherePublished(1)->with(['public_products'])->get();

			foreach ($catalogs as $catalog){
				foreach ($catalog->public_products()
                             ->with(['sizes', 'seasons', 'brand', 'genders', 'types'])
                             ->get() as $product){
					self::create([
						'product_id' => $product->id,
                        'sizes' => $product->sizes()->pluck('value')->all(),
                        'seasons' => $product->seasons()->pluck('value')->all(),
                        'brand' => $product->brand->value,
                        'genders' => $product->genders()->pluck('value')->all(),
                        'types' => $product->types()->pluck('value')->all()
					]);
				}
			}

			DB::commit();

		} catch (\Exception $e){
            \Debugbar::log($e->getMessage());
			DB::rollBack();
		}
	}

	public function getAnnounceAttribute() {
		$text = strip_tags($this->text);

		return Str::words($text, 50);
	}
}
