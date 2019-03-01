<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class DeleteAccountController
 *
 * @package App\Http\Controllers\Account
 */
class DeleteAccountController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * DeleteAccountController constructor.
     *
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->middleware([ 'auth', 'verified' ]);

        $this->users = $users;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('account.delete');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Request $request)
    {
        $this->validateDestroyRequest($request);

        $this->users->destroy($request->user());

        return redirect()->route('welcome')->withSuccess('Your account has been deleted successfully!');
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateDestroyRequest(Request $request)
    {
        $password = $request->user()->password;

        $this->validate($request, [
            'password' => [
                'required',
                function ($attribute, $value, $fail) use ($password) {
                    if (!Hash::check($value, $password)) {
                        return $fail('The ' . $attribute . ' is incorrect.');
                    }
                },
            ]
        ]);
    }
}
