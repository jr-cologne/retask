<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;

/**
 * Class EditAccountController
 *
 * @package App\Http\Controllers\Account
 */
class EditAccountController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * EditAccountController constructor.
     *
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->middleware([ 'auth', 'verified' ]);

        $this->users = $users;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return view('account.edit', compact([ 'user' ]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validateUpdateRequest($request);

        if ($data = $this->getChangedData($request->only([
            'name',
            'email',
            'password',
        ]))) {
            $this->users->update($data, $request->user());

            return redirect()->route('account.index')->withSuccess('Your account details have successfully been updated!');
        }

        return redirect()->route('account.edit');
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateUpdateRequest(Request $request)
    {
        $this->validate($request, $this->rules());
    }

    /**
     * @return array
     */
    protected function rules() : array
    {
        $rules = User::rules();

        $rules = $this->makeFieldsOptional($rules);

        return $rules;
    }

    /**
     * @param array $rules
     * @return array
     */
    protected function makeFieldsOptional(array $rules)
    {
        foreach ($rules as $field => $field_rules) {
            // nothing should be required
            $rules[$field] = array_filter($rules[$field], function ($value) {
                return $value !== 'required';
            });

            // make fields nullable
            $rules[$field][] = 'nullable';
        }

        return $rules;
    }

    protected function getChangedData(array $data) : array
    {
        return array_filter($data, function ($value) {
            return $value;
        });
    }
}
