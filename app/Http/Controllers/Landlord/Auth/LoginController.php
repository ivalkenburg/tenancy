<?php

namespace App\Http\Controllers\Landlord\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:landlord')->except('logout');
    }

    /**
     * @inheritDoc
     */
    public function showLoginForm()
    {
        return view('landlord.auth.login');
    }

    /**
     * @inheritDoc
     */
    protected function guard()
    {
        return Auth::guard('landlord');
    }
}
