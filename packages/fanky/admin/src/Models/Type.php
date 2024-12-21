<?php

namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Type extends Model
{
    protected $fillable = ['value', 'order'];

    public $timestamps = false;

    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
