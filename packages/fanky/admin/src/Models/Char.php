<?php

namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static whereProductId(\Illuminate\Support\HigherOrderCollectionProxy|int|mixed $id)
 * @method static findOrNew(mixed $array_get)
 */
class Char extends Model
{
    protected $fillable = ['product_id', 'name', 'value', 'order'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
