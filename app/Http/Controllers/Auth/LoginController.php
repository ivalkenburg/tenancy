<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    const REDIRECT = '/';

    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function extLogin($token)
    {
        abort_unless($userId = Cache::get($token), Response::HTTP_NOT_FOUND);

        Auth::login(User::findOrFail($userId));

        return redirect($this->redirectPath());
    }

    /**
     * @inheritDoc
     */
    public function redirectPath()
    {
        return static::REDIRECT;
    }
}
