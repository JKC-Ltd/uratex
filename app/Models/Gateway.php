<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gateway extends Model
{   
    use SoftDeletes;
    protected $fillable = [
        'location_id',
        'customer_code',
        'gateway',
        'gateway_code',
        'description',

    ];

    public function location() 
    {
        return $this->belongsTo(Location::class);
    }
}
