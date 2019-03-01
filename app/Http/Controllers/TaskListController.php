<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\TaskListRepository;
use App\Repositories\TaskRepository;
use App\TaskList;

/**
 * Class ListController
 *
 * @package App\Http\Controllers
 */
class ListController extends Controller
{
    /**
     * @var TaskListRepository
     */
    protected $lists;

    /**
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * ListController constructor.
     *
     * @param TaskListRepository $lists
     * @param TaskRepository $tasks
     */
    public function __construct(TaskListRepository $lists, TaskRepository $tasks)
    {
        $this->middleware([ 'auth', 'verified' ]);

        $this->lists = $lists;
        $this->tasks = $tasks;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $lists = $this->lists->forUser($request->user());

        return view('lists', compact([ 'lists' ]));
    }

    /**
     * @param TaskList $list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(TaskList $list)
    {
        $this->authorize('show', $list);

        $tasks = $this->tasks->forList($list);

        return view('list', compact([ 'list', 'tasks' ]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validateStoreRequest($request);

        $this->lists->storeForUser($request->only([ 'name' ]), $request->user());

        return redirect()->route('list.index');
    }

    /**
     * @param TaskList $list
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
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

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateStoreRequest(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255'
        ]);
    }
}
