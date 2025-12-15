<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SensorModel extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sensor_model',
        'sensor_brand',
        'sensor_type_id',
        'sensor_reg_address',
    ];

    public function sensorType() 
    {
        return $this->belongsTo(SensorType::class);
    }
}
