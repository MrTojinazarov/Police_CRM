<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'executer',
        'title',
        'description',
        'file',
        'deadline'
    ];

    public function catagories()
    {
        return $this->belongsTo(Category::class, 'id', 'category_id');
    }

    public function regionTasks()
    {
        return $this->hasMany(RegionTask::class, 'task_id');
    }

    public function responses()
    {
        return $this->hasMany(Response::class, 'id', 'task_id');
    }

}
