<?php namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model {

    protected $table = 'orders';

    protected $guarded = ['id'];

    const UPLOAD_PATH = '/public/uploads/orders/';
    const UPLOAD_URL  = '/uploads/orders/';

    public function dateFormat($format = 'd.m.Y')
    {
        if (!$this->created_at) return null;
        return date($format, strtotime($this->created_at));
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany('Fanky\Admin\Models\Product')
            ->withPivot('count', 'price');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    public function point(): BelongsTo
    {
        return $this->belongsTo(Point::class)->withDefault(['name' => '-']);
    }

    public function sxgeo_region(): BelongsTo
    {
        return $this->belongsTo(SxgeoRegion::class)->withDefault(['name' => '-']);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class)->withDefault(['name' => '-']);
    }

//    public function payment_order() {
//        return $this->hasOne(PaymentOrder::class)->first();
//    }

//    public function getPaymentId($query) {
//        return $query->whereNew(1);
//    }

//	public function getPaymentStatus($query) {
//		return $query->whereNew(1);
//	}

    public function scopeNewOrder($query) {
        return $query->whereNew(1);
    }

}
