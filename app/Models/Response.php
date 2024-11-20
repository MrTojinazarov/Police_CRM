<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = [
        'title',
        'file',
        'note',
        'status'
    ];

    public function regions()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    public function tasks()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}