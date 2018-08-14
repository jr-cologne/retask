<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\TaskList;

class TaskListPolicy
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

    public function show(User $user, TaskList $list)
    {
        return $user->id === $list->user_id;
    }

    public function update(User $user, TaskList $list)
    {
        return $user->id === $list->user_id;
    }

    public function destroy(User $user, TaskList $list)
    {
        return $user->id === $list->user_id;
    }
}
