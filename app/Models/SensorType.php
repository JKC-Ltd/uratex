<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SensorType extends Model
{
    use SoftDeletes;
        protected $fillable = ['sensor_type_code', 'description', 'sensor_type_parameter'];
}
