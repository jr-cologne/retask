<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\TaskList;

/**
 * Class TaskListPolicy
 *
 * @package App\Policies
 */
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

    /**
     * @param User $user
     * @param TaskList $list
     * @return bool
     */
    public function show(User $user, TaskList $list)
    {
        return $this->touch($user, $list);
    }

    /**
     * @param User $user
     * @param TaskList $list
     * @return bool
     */
    public function update(User $user, TaskList $list)
    {
        return $this->touch($user, $list);
    }

    /**
     * @param User $user
     * @param TaskList $list
     * @return bool
     */
    public function destroy(User $user, TaskList $list)
    {
        return $this->touch($user, $list);
    }

    /**
     * @param User $user
     * @param TaskList $list
     * @return bool
     */
    protected function touch(User $user, TaskList $list)
    {
        return $user->id === $list->user_id;
    }
}
