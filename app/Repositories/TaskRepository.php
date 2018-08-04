<?php

namespace App\Repositories;

use App\User;
use App\TaskList;

class TaskRepository
{
    public function forUser(User $user)
    {
        return $user->tasks()->latest()->get();
    }

    public function forUserWithList(User $user)
    {
        return $user->tasks()->with('list')->latest()->get();
    }

    public function forList(TaskList $list)
    {
        return $list->tasks()->latest()->get();
    }
}
