<?php

namespace App\Repositories;

use App\{
    User,
    TaskList,
    Task
};

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

    public function storeForUser(array $data, User $user)
    {
        $user->tasks()->create($data);
    }

    public function updateByIdForUser(int $id, array $data, User $user)
    {
        $user->tasks()->where('id', $id)->update($data);
    }

    public function updateForList(TaskList $list)
    {
        $list->tasks()->update([ 'task_list_id' => null ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
    }

    public function destroyForList(TaskList $list)
    {
        $list->tasks()->delete();
    }
}
