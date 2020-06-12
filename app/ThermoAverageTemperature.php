<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThermoAverageTemperature extends Model
{
    protected $table = 'thermos_average_temperature';

    protected $fillable = [
        'client_id',
        'client_thermo',
        'thermo_type',
        'imei',
        'morning_temp',
        'afternoon_temp'
    ];

    public static function alias($alias) {
        return (new static)->table . ' as ' . $alias;
    }
}
