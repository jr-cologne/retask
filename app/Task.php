<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\{
    User,
    TaskList
};

class Task extends Model
{
    protected $fillable = [
        'task',
        'task_list_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function list()
    {
        return $this->belongsTo(TaskList::class, 'task_list_id');
    }
}
