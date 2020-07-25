<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Rules\RoleExists;
use App\Support\Multitenancy\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Validation\Rule;

class CreateUser extends Command
{
    protected $signature = 'app:create-user {email} {name} {role} {password?} {--silence-error}';
    protected $description = 'Create a user';

    /**
     * @return int
     */
    public function handle()
    {
        if (Tenant::isMultitenancyEnabled()) {
            $this->error('Multitenancy needs to be disabled to create a user.');
            return $this->option('silence-error') ? 0 : 1;
        }

        $validator = $this->argumentsValidator();

        if ($validator->fails()) {
            return $this->handleValidationFailure($validator);
        }

        $user = $this->createUser();

        $this->info("User [{$user->name}] with ID [{$user->id}] created successfully.");

        return 0;
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function argumentsValidator()
    {
        return validator($this->arguments(), [
            'email' => ['required', 'email', Rule::unique('users')],
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', new RoleExists],
            'password' => ['nullable', 'string'],
        ]);
    }

    /**
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return int
     */
    protected function handleValidationFailure($validator)
    {
        $errors = collect($validator->errors()->toArray())->flatten();

        foreach ($errors as $error) {
            $this->error($error);
        }

        return $this->option('silence-error') ? 0 : 1;
    }

    /**
     * @return User
     */
    protected function createUser()
    {
        $user = User::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'confirmed' => (bool)$this->argument('password'),
            'password' => $this->argument('password'),
        ]);

        $user->assignRole($this->argument('role'));

        return $user;
    }
}
