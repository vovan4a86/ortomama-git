<?php

namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Brand extends Model
{
    protected $fillable = ['name', 'order'];

    public $timestamps = false;

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
