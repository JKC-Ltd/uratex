<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTypeLocation extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'user_type_id',
        'locations_list'
    ];

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }
}
