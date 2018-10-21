<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\Task;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Task $task)
    {
        return $this->touch($user, $task);
    }

    public function destroy(User $user, Task $task)
    {
        return $this->touch($user, $task);
    }

    protected function touch(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }
}
