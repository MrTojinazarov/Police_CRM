<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionTask extends Model
{
    protected $fillable = [
        'region_id',
        'task_id'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'region_tasks', 'region_id', 'task_id');
    }
}
