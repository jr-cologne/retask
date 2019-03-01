<?php

namespace App\Http\Controllers\Account;

use App\Events\Account\UserUpdatedEmail;
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

        if (!$data = $this->getChangedData($request->only([
            'name',
            'email',
            'password',
        ]))) {
            return redirect()->route('account.edit');
        }

        $this->users->update($data, $request->user());

        if ($this->emailWasUpdated($data)) {
            event(new UserUpdatedEmail($request->user()));

            return redirect()->route('verification.notice')->with([
                'success' => 'Your account details have successfully been updated!',
                'status' => 'Because you changed your email, we have temporarily deactivated your account. Please make sure to reactivate your account. For this reason, an email has been sent to your new email address.'
            ]);
        }

        return redirect()->route('account.index')->withSuccess('Your account details have successfully been updated!');
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

    /**
     * @param array $data
     * @return array
     */
    protected function getChangedData(array $data) : array
    {
        return array_filter($data, function ($value) {
            return $value;
        });
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function emailWasUpdated(array $data) : bool
    {
        return array_key_exists('email', $data);
    }
}
