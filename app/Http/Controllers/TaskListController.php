<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\TaskListRepository;
use App\Repositories\TaskRepository;
use App\TaskList;

class ListController extends Controller
{
    protected $lists;
    protected $tasks;

    public function __construct(TaskListRepository $lists, TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->lists = $lists;
        $this->tasks = $tasks;
    }

    public function index(Request $request)
    {
        return view('lists', [
            'lists' => $this->lists->forUser($request->user())
        ]);
    }

    public function show(TaskList $list)
    {
        $this->authorize('show', $list);

        return view('list', [
            'list' => $list,
            'tasks' => $this->tasks->forList($list)
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $request->user()->lists()->create([
            'name' => $request->get('name')
        ]);

        return redirect()->route('list.index');
    }

    public function destroy(TaskList $list, Request $request)
    {
        $this->authorize('destroy', $list);

        if ((bool) $request->get('delete_tasks')) {
            $list->tasks()->delete();
        } else {
            $list->tasks()->update([ 'task_list_id' => null ]);
        }

        $list->delete();

        return redirect()->route('list.index');
    }
}
