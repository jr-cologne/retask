<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Repositories\UserRepository;

class ActivationController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function activate(Request $request)
    {
        $this->authorizeActivation($request);

        $user = $this->users->forActivation($request->email, $request->activation_token);

        $this->users->updateForActivation($user);

        Auth::loginUsingId($user->id);

        return redirect()->route('task.index')
            ->withSuccess('Your account has been activated successfully.');
    }

    protected function authorizeActivation(Request $request)
    {
        if (!$request->email || !$request->activation_token) {
            abort(403, 'Unauthorized action.');
        }
    }
}
