<?php

namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static whereProductId(\Illuminate\Support\HigherOrderCollectionProxy|int|mixed $id)
 * @method static findOrNew(mixed $array_get)
 */
class Char extends Model
{
    protected $fillable = ['product_id', 'name', 'value', 'order'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
