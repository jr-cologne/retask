<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\TaskRepository;
use App\Repositories\TaskListRepository;
use App\Task;
use App\TaskList;

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
        $this->validate($request, [
            'task' => 'required|max:255',
            'list' => 'required|numeric',
            'new_list' => 'nullable|max:255'
        ]);

        $list = (int) $request->list;

        $new_list = $request->new_list;

        $data = $request->only([ 'task' ]);

        // assign task to existing list
        if ($list !== 0) {
            $list = TaskList::find($list);

            if ($list) {
                $data = array_merge($data, [
                    'task_list_id' => $list->id
                ]);
            }
        }

        // create new list and assign task to it
        if ($list === 0 && $new_list) {
            $new_list_id = $request->user()->lists()->create([
                'name' => $new_list
            ])->id;

            $data = array_merge($data, [
                'task_list_id' => $new_list_id
            ]);
        }

        $request->user()->tasks()->create($data);

        return redirect()->route('task.index');
    }

    public function destroy(Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return back();
    }
}
