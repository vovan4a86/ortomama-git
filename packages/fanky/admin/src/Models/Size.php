<?php

namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Size extends Model
{
    protected $fillable = ['value'];

    public $timestamps = false;

    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
