<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{
    Repositories\TaskRepository,
    Repositories\TaskListRepository,
    Task
};

class TaskController extends Controller
{
    protected $tasks;
    protected $lists;

    public function __construct(TaskRepository $tasks, TaskListRepository $lists)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
        $this->lists = $lists;
    }

    public function index(Request $request)
    {
        $tasks = $this->tasks->forUserWithList($request->user());
        $lists = $this->lists->forUser($request->user());

        return view('tasks', compact([ 'tasks', 'lists' ]));
    }

    public function store(Request $request)
    {
        $this->validateStoreRequest($request);

        $list = (int) $request->list;

        $new_list = $request->new_list;

        $data = $request->only([ 'task' ]);

        // assign task to existing list
        if ($list !== 0) {
            $data = array_merge($data, $this->assignTaskToExistingList($list));
        }

        // store new list and assign task to it
        if ($list === 0 && $new_list) {
            $data = array_merge($data, $this->storeNewListAndAssignTask($new_list));
        }

        $this->tasks->storeForUser($data, $request->user());

        return redirect()->route('task.index');
    }

    public function destroy(Task $task)
    {
        $this->authorize('destroy', $task);

        $this->tasks->destroy($task);

        return back();
    }

    protected function validateStoreRequest(Request $request)
    {
        $this->validate($request, [
            'task' => 'required|string|max:255',
            'list' => 'required|numeric',
            'new_list' => 'nullable|string|max:255'
        ]);
    }

    protected function assignTaskToExistingList(int $list) : array
    {
        $list = $this->lists->byIdForUser($list, request()->user());

        if (!$list) {
            return [];
        }

        return [
            'task_list_id' => $list->id
        ];
    }

    protected function storeNewListAndAssignTask(string $new_list) : array
    {
        $new_list = $this->lists->storeForUser([
            'name' => $new_list
        ], request()->user());

        if (!$new_list) {
            return [];
        }

        return [
            'task_list_id' => $new_list->id
        ];
    }
}
