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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function regiontasks()
    {
        return $this->hasMany(RegionTask::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

}
