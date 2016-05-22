<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'priority', 'done'];

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'task_tag');
    }
}
