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

    protected $redirectTo = '/';
    protected $defaultRole = 'Default User';

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
            'email' => ['required', 'string', 'email', 'max:255', Unique::on('users')],
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
        $user->assignRole($this->defaultRole);
    }
}
