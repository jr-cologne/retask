<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\Task;

/**
 * Class TaskPolicy
 *
 * @package App\Policies
 */
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

    /**
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function edit(User $user, Task $task)
    {
        return $this->touch($user, $task);
    }

    /**
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function destroy(User $user, Task $task)
    {
        return $this->touch($user, $task);
    }

    /**
     * @param User $user
     * @param Task $task
     * @return bool
     */
    protected function touch(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }
}
