<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\TaskRepository;
use App\Repositories\TaskListRepository;
use App\Task;

class TaskController extends Controller
{
    protected $tasks;
    protected $lists;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TaskRepository $tasks, TaskListRepository $lists)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
        $this->lists = $lists;
    }

    public function index(Request $request)
    {
        return view('tasks', [
            'tasks' => $this->tasks->forUserWithList($request->user()),
            'lists' => $this->lists->forUser($request->user())
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'task' => 'required|max:255',
            'list' => 'required|numeric'
        ]);

        $list = (int) $request->get('list');

        $data = [
            'task' => $request->get('task')
        ];

        if ($list !== 0) {
            $data = array_merge($data, [
                'task_list_id' => $list
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
