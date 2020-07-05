<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Routing\Controller;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/';

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
}
