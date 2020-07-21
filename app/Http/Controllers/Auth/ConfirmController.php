<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Notifications\User\ConfirmedNotification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ConfirmController extends Controller
{
    const REDIRECT = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param string $token
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function show($token, Request $request)
    {
        return view('auth.confirm', [
            'token' => $token,
            'email' => $request->get('email'),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        if (!$user = $this->getUserByCombination($request->email, $request->token)) {
            throw ValidationException::withMessages([
                'email' => 'Invalid token/email combination.'
            ]);
        }

        if (!$this->confirmUser($user, $request->password)) {
            throw ValidationException::withMessages([
                'email' => 'Failed to confirm user account.'
            ]);
        }

        Auth::login($user);

        return redirect(static::REDIRECT);
    }

    /**
     * @param string $email
     * @param string $token
     * @return User
     */
    protected function getUserByCombination($email, $token)
    {
        return User::where([
            'confirmed' => false,
            'email' => $email,
            'confirmation_token' => $token
        ])->first();
    }

    /**
     * @param User $user
     * @param string $password
     * @return boolean
     */
    protected function confirmUser($user, $password)
    {
        $confirmed = $user->update([
            'password' => $password,
            'confirmed' => true,
            'confirmation_token' => null,
        ]);

        if ($confirmed) {
            $user->notify(new ConfirmedNotification(request()->ip()));
        }

        return $confirmed;
    }
}
