<?php

namespace App\Console\Commands;

use App\Models\Landlord;
use App\Support\Multitenancy\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Validation\Rule;

class CreateLandlord extends Command
{
    protected $signature = 'app:create-landlord {name} {email} {password} {--silent-error}';
    protected $description = 'Create landlord for managing tenants';

    /**
     * @return int
     */
    public function handle()
    {
        if (!Tenant::isMultitenancyEnabled()) {
            $this->error('Multitenancy needs to be enabled to create a landlord.');
            return $this->option('silent-error') ? 0 : 1;
        }

        $validator = $this->argumentsValidator();

        if ($validator->fails()) {
            return $this->handleValidationFailure($validator);
        }

        $landlord = Landlord::create($validator->validated());

        $this->info("Landlord [{$landlord->name}] with ID [{$landlord->id}] created successfully.");

        return 0;
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function argumentsValidator()
    {
        return validator($this->arguments(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('landlords')],
            'password' => ['required', 'string'],
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

        return $this->option('silent-error') ? 0 : 1;
    }
}
