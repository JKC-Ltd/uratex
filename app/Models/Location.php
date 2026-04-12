<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'location_code',
        'location_name',
        'pid',
        'branch_id',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function parent()
    {
        return $this->belongsTo(Location::class, 'pid');
    }
    public function children()
    {
        return $this->hasMany(Location::class, 'pid');
    }

    public static function getParentLocation($locationId, $parents = [])
    {
        $location = self::find($locationId);
        if ($location && $location->pid) {
            $parent = self::find($location->pid);
            if ($parent) {
                  array_unshift($parents, $parent);
                return self::getParentLocation($parent->id, $parents);
            }
        }
        
        return $parents;    
    }
}
