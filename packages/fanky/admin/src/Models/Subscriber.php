<?php

namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static whereEmail(mixed $email)
 */
class Subscriber extends Model
{
    protected $fillable = ['email'];
}
