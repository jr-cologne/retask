<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

/**
 * Class AccountController
 *
 * @package App\Http\Controllers\Account
 */
class AccountController extends Controller
{
    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware([ 'auth', 'verified' ])->except('deleted');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return view('account.index', compact([ 'user' ]));
    }
}
