<?php

namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    public function order(): void
    {
        $this->hasOne(Order::class);
    }
}
