<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\UserRepository;
use App\Events\Auth\UserRequestedActivationEmail;

class ActivationResendController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function showResendForm()
    {
        return view('auth.activate.resend');
    }

    public function resend(Request $request)
    {
        $this->validateResendRequest($request);

        $user = $this->users->forEmail($request->email);

        event(new UserRequestedActivationEmail($user));

        return redirect()->route('login')
            ->withSuccess('Your accout activation email has been resent successfully.');
    }

    protected function validateResendRequest(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Account not found.'
        ]);
    }
}
