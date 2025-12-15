<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SensorRegister extends Model
{

    use SoftDeletes;
    protected $fillable = ['sensor_type_id', 'sensor_model_id', 'sensor_reg_address'];


    public function sensorModel() 
    {
        return $this->belongsTo(SensorModel::class);
    }

    public function sensorType() 
    {
        return $this->belongsTo(SensorType::class);
    }
    
}