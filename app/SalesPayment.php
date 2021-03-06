<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SalesPayment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'salespayments';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public static function alias($alias) {
        return (new static)->table . ' as ' . $alias;
    }
}
