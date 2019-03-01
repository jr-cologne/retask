<?php

namespace App\Repositories;

use App\User;
use App\TaskList;

/**
 * Class TaskListRepository
 *
 * @package App\Repositories
 */
class TaskListRepository
{
    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function forUser(User $user)
    {
        return $user->lists()->latest()->get();
    }

    /**
     * @param int $id
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function byIdForUser(int $id, User $user)
    {
        return $user->lists()->where('id', $id)->first();
    }

    /**
     * @param array $data
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function storeForUser(array $data, User $user)
    {
        return $user->lists()->create($data);
    }

    /**
     * @param TaskList $list
     * @throws \Exception
     */
    public function destroy(TaskList $list)
    {
        $list->delete();
    }
}
