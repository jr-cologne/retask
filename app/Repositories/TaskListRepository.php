<?php

namespace App\Repositories;

use App\User;

class TaskListRepository
{
    public function forUser(User $user)
    {
        return $user->lists()->latest()->get();
    }
}
