<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Routing\Controller;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    const REDIRECT = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @inheritDoc
     */
    protected function setUserPassword($user, $password)
    {
        $user->password = $password;
    }

    /**
     * @inheritDoc
     */
    protected function rules()
    {
        return [
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function redirectPath()
    {
        return static::REDIRECT;
    }
}
