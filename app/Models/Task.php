<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'performer',
        'file',
        'deadline',
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function regiontasks()
    {
        return $this->hasMany(RegionTask::class);
    }    

    public function regions()
    {
        return $this->belongsToMany(Region::class, 'region_tasks', 'task_id', 'region_id');
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}

