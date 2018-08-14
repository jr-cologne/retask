<?php

namespace App\Repositories;

use App\{
    User,
    TaskList
};

class TaskListRepository
{
    public function forUser(User $user)
    {
        return $user->lists()->latest()->get();
    }

    public function byIdForUser(int $id, User $user)
    {
        return $user->lists()->where('id', $id)->first();
    }

    public function storeForUser(array $data, User $user)
    {
        return $user->lists()->create($data);
    }

    public function destroy(TaskList $list)
    {
        $list->delete();
    }

}
