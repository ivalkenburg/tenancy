<?php

namespace App\Http\Controllers\Landlord\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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
    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
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
