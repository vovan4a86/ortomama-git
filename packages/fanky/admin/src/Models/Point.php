<?php

namespace Fanky\Admin\Models;

use App\Traits\HasH1;
use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Point extends Model
{
    use HasSeo, HasH1;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function order(): void
    {
        $this->hasOne(Order::class);
    }

    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

}
