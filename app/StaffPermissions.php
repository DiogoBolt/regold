<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StaffPermissions extends Model
{
    protected $table = 'staff_permissions';

    public static function alias($alias) {
        return (new static)->table . ' as ' . $alias;
    }
}
