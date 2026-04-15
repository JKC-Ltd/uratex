<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    protected $table = 'branches';

    protected $fillable = [
        'name',
        'branch_code',
    ];
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
