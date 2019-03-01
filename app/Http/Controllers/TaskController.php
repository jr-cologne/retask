<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\TaskRepository;
use App\Repositories\TaskListRepository;
use App\Task;

/**
 * Class TaskController
 *
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    /**
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * @var TaskListRepository
     */
    protected $lists;

    /**
     * TaskController constructor.
     *
     * @param TaskRepository $tasks
     * @param TaskListRepository $lists
     */
    public function __construct(TaskRepository $tasks, TaskListRepository $lists)
    {
        $this->middleware([ 'auth', 'verified' ]);

        $this->tasks = $tasks;
        $this->lists = $lists;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tasks = $this->tasks->forUserWithList($request->user());
        $lists = $this->lists->forUser($request->user());

        return view('tasks', compact([ 'tasks', 'lists' ]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validateStoreRequest($request);

        $data = $this->makeTaskData($request);

        $this->tasks->storeForUser($data, $request->user());

        return redirect()->route('task.index');
    }

    /**
     * @param Task $task
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Task $task, Request $request)
    {
        $this->authorize('edit', $task);

        $lists = $this->lists->forUser($request->user());

        return view('task.edit', compact([ 'task', 'lists' ]));
    }

    /**
     * @param Task $task
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Task $task, Request $request)
    {
        $this->validateUpdateRequest($request);

        $data = $this->makeTaskData($request);

        $this->tasks->updateByIdForUser($task->id, $data, $request->user());

        return back();
    }

    /**
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Task $task)
    {
        $this->authorize('destroy', $task);

        $this->tasks->destroy($task);

        return back();
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateStoreRequest(Request $request)
    {
        $this->validate($request, $this->rules());
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function makeTaskData(Request $request) : array
    {
        $list = (int) $request->list;

        $new_list = $request->new_list;

        $data = $request->only([ 'task' ]);

        // assign task to existing list
        if ($list !== 0) {
            return array_merge($data, $this->assignTaskToExistingList($list));
        }

        // store new list and assign task to it
        if ($list === 0 && $new_list) {
            return array_merge($data, $this->storeNewListAndAssignTask($new_list));
        }

        // task without list
        $data['task_list_id'] = null;

        return $data;
    }

    /**
     * @param int $list
     * @return array
     */
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

    /**
     * @param string $new_list
     * @return array
     */
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

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateUpdateRequest(Request $request)
    {
        $this->validateStoreRequest($request);
    }

    /**
     * @return array
     */
    protected function rules() : array
    {
        return [
            'task' => 'required|string|max:255',
            'list' => 'required|numeric',
            'new_list' => 'nullable|string|max:255'
        ];
    }
}
