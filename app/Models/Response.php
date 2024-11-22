<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = [
        'task_id',
        'region_id',
        'title',
        'file',
        'note',
        'status'
    ];

    public function regions()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function tasks()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
