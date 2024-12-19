<?php namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Fanky\Admin\Models\Delivery
 *
 * @property int        $id
 * @property string     $name
 * @property int        $order
 * @method static Builder|Payment whereId($value)
 * @method static Builder|Payment whereName($value)
 * @method static Builder|Payment whereOrder($value)
 * @mixin \Eloquent
 * @method static Builder|Payment newModelQuery()
 * @method static Builder|Payment newQuery()
 * @method static Builder|Payment query()
 */
class Delivery extends Model {

    protected $guarded = ['id'];

	public $timestamps = false;

	public function order() {
	    $this->hasMany(Order::class, 'payment_item_id');
    }

}
