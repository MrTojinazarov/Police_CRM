<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionTask extends Model
{
    protected $fillable = [
        'region_id',
        'task_id',
        'category_id',
        'deadline',
        'status',
    ];

    public function regions()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function tasks()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
}
