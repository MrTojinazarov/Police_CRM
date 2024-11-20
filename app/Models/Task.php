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
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function regiontasks()
    {
        return $this->belongsToMany(RegionTask::class, 'region_tasks', 'task_id', 'region_id');
    }    

    public function responses()
    {
        return $this->hasMany(Response::class, 'task_id', 'id');
    }
}

