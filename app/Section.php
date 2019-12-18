<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Section extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'section';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public static function alias($alias) {
        return (new static)->table . ' as ' . $alias;
    }
}
