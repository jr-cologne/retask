<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\{
    Repositories\TaskListRepository,
    Repositories\TaskRepository,
    TaskList
};

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
        $lists = $this->lists->forUser($request->user());

        return view('lists', compact([ 'lists' ]));
    }

    public function show(TaskList $list)
    {
        $this->authorize('show', $list);

        $tasks = $this->tasks->forList($list);

        return view('list', compact([ 'list', 'tasks' ]));
    }

    public function store(Request $request)
    {
        $this->validateStoreRequest($request);

        $this->lists->storeForUser($request->only([ 'name' ]), $request->user());

        return redirect()->route('list.index');
    }

    public function destroy(TaskList $list, Request $request)
    {
        $this->authorize('destroy', $list);
        $this->authorize('update', $list);

        if ((bool) $request->delete_tasks) {
            $this->tasks->destroyForList($list);
        } else {
            $this->tasks->updateForList($list);
        }

        $this->lists->destroy($list);

        return redirect()->route('list.index');
    }

    protected function validateStoreRequest(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);
    }
}
