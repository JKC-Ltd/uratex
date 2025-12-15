<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sensor extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'slave_address',
        'description',
        'location_id',
        'gateway_id',
        'sensor_model_id',
    ];

    public function location() 
    {
        return $this->belongsTo(Location::class);
    }

    public function gateway() 
    {
        return $this->belongsTo(Gateway::class);
    }
    
    public function sensorLogs()
    {
        return $this->hasMany(SensorLog::class);
    }

    public function sensorModel()
    {
        return $this->belongsTo(SensorModel::class);
    }

}
