<?php

namespace Fanky\Admin\Models;

use App\Traits\HasH1;
use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasSeo, HasH1;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function order(): void
    {
        $this->hasOne(Order::class);
    }
}
