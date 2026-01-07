<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserType extends Model
{
    use SoftDeletes;    
    protected $table = 'user_types';

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function userTypeLocations()
    {
        return $this->hasMany(UserTypeLocation::class, 'user_type_id');
    }
}
