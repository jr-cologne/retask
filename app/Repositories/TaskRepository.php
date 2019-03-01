<?php

namespace App\Repositories;

use App\User;
use App\TaskList;
use App\Task;

/**
 * Class TaskRepository
 *
 * @package App\Repositories
 */
class TaskRepository
{
    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function forUser(User $user)
    {
        return $user->tasks()->latest()->get();
    }

    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function forUserWithList(User $user)
    {
        return $user->tasks()->with('list')->latest()->get();
    }

    /**
     * @param TaskList $list
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function forList(TaskList $list)
    {
        return $list->tasks()->latest()->get();
    }

    /**
     * @param array $data
     * @param User $user
     */
    public function storeForUser(array $data, User $user)
    {
        $user->tasks()->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @param User $user
     */
    public function updateByIdForUser(int $id, array $data, User $user)
    {
        $user->tasks()->where('id', $id)->update($data);
    }

    /**
     * @param TaskList $list
     */
    public function updateForList(TaskList $list)
    {
        $list->tasks()->update([ 'task_list_id' => null ]);
    }

    /**
     * @param Task $task
     * @throws \Exception
     */
    public function destroy(Task $task)
    {
        $task->delete();
    }

    /**
     * @param TaskList $list
     */
    public function destroyForList(TaskList $list)
    {
        $list->tasks()->delete();
    }
}
