<?php

namespace App\Http\Controllers\Auth;

use App\Support\Multitenancy\Rules\Unique;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    const REDIRECT = '/';
    const DEFAULT_ROLE = 'Default User';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Unique::on('users')],
            'password' => ['required', 'string', 'confirmed'],
        ]);
    }

    /**
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function registered(Request $request, $user)
    {
        $user->assignRole(static::DEFAULT_ROLE);
    }

    /**
     * @inheritDoc
     */
    public function redirectPath()
    {
        return static::REDIRECT;
    }
}
