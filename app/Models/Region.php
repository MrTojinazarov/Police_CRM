<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        'user_id',
        'name',
    ];

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function tasks()
    {
        return $this->hasMany(RegionTask::class, 'id', 'region_id');
    }

    public function responses()
    {
        return $this->hasMany(Response::class, 'id', 'region_id');
    }
}
