<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CleaningFrequency extends Model
{
    protected $table = 'cleaning_frequency';

    public static function alias($alias) {
        return (new static)->table . ' as ' . $alias;
    }
}
