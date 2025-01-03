<?php

namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static whereValue(string $brand)
 */
class Brand extends Model
{
    protected $fillable = ['value', 'order'];

    public $timestamps = false;

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
