<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Task;

class TaskList extends Model
{
    protected $fillable = [
        'name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
