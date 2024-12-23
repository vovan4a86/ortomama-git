<?php namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Fanky\Admin\Models\Payment
 *
 * @property int        $id
 * @property string     $name
 * @property int        $order
 * @method static Builder|Delivery whereId($value)
 * @method static Builder|Delivery whereName($value)
 * @method static Builder|Delivery whereOrder($value)
 * @mixin \Eloquent
 * @method static Builder|Delivery newModelQuery()
 * @method static Builder|Delivery newQuery()
 * @method static Builder|Delivery query()
 */
class Payment extends Model {

    protected $guarded = ['id'];

	public $timestamps = false;

	public function order(): void
    {
	    $this->hasOne(Order::class);
    }

}
