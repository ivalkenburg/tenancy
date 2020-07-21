<?php

namespace App\Http\Controllers\Landlord\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    const REDIRECT = '/';

    public function __construct()
    {
        $this->middleware('guest:landlord');
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
    protected function guard()
    {
        return Auth::guard('landlord');
    }

    /**
     * @inheritDoc
     */
    public function broker()
    {
        return Password::broker('landlords');
    }

    /**
     * @inheritDoc
     */
    public function redirectPath()
    {
        return static::REDIRECT;
    }
}
