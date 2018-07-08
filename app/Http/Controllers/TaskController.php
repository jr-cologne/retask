<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\TaskRepository;
use App\Task;

class TaskController extends Controller
{
    protected $tasks;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }

    public function index(Request $request)
    {
        return view('tasks', [
            'tasks' => $this->tasks->forUser($request->user())
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'task' => 'required|max:255'
        ]);

        $request->user()->tasks()->create([
            'task' => $request->get('task')
        ]);

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect()->route('tasks.index');
    }
}
