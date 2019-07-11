<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OrderLine extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'order_line';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public static function alias($alias) {
        return (new static)->table . ' as ' . $alias;
    }
}
