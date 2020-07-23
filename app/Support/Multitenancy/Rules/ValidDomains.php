<?php

namespace App\Support\Multitenancy\Rules;

use App\Support\Multitenancy\Models\Tenant;
use Illuminate\Contracts\Validation\Rule;

class ValidDomains implements Rule
{
    protected $message = 'One ore more invalid domains given.';

    /**
     * @param string $tenant
     * @return static
     */
    public static function forTenant($tenant)
    {
        return new static($tenant);
    }

    /**
     * @param string $tenant
     */
    public function __construct($tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        validator($value, [
            '*.name' => ['required', 'string'],
            '*.default' => ['required', 'boolean'],
        ]);
    }

    /**
     * @param string $message
     * @return bool
     */
    protected function fail($message)
    {
        $this->message = $message;

        return false;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return $this->message;
    }
}
