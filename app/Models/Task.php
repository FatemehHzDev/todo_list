<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
   public $timestamps = false;
    public function user():  BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function taskDos()
    {
        return $this->hasMany(Task_do::class);
    }



}
