<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\{
    Http\Controllers\Controller,
    Repositories\UserRepository
};

class AccountController extends Controller
{
    public function __construct(UserRepository $users)
    {
        $this->middleware([ 'auth', 'verified' ])->except('deleted');

        $this->users = $users;
    }

    public function index(Request $request)
    {
        $user = $request->user();

        return view('account.index', compact([ 'user' ]));
    }

    public function delete()
    {
        return view('account.delete');
    }

    public function destroy(Request $request)
    {
        $this->validateDestroyRequest($request);

        $this->users->destroy($request->user());

        return redirect()->route('account.deleted')->withSuccess('Your account has been deleted successfully!');
    }

    public function deleted()
    {
        return view('account.deleted');
    }

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
