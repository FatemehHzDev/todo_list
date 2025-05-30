<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task_do extends Model
{
    public $timestamps =false;
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

}
