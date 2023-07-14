<?php

namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
