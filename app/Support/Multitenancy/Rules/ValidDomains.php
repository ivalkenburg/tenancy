<?php

namespace App\Support\Multitenancy\Rules;

use App\Rules\AllowedAttributes;
use App\Support\Multitenancy\Models\Tenant;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ValidDomains implements Rule
{
    /** @var string */
    protected $message = 'One ore more invalid domains given.';

    /** @var string|null */
    protected $tenantId;

    /**
     * @param Tenant|string $tenant
     * @return static
     */
    public static function forTenant($tenant)
    {
        return new static($tenant);
    }

    /**
     * @param Tenant|string|null $tenant
     */
    public function __construct($tenant = null)
    {
        $this->tenantId = $tenant instanceof Tenant ? $tenant->id : $tenant;
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $domains)
    {
        if (!$this->validStructure($domains)) {
            return $this->fail('The given array does not meet the required structure.');
        }

        if (!$this->validDomains($domains)) {
            return $this->fail('One or more domains are invalid.');
        }

        return true;
    }

    /**
     * @param array $domains
     * @return mixed
     */
    protected function validStructure($domains)
    {
        return Validator::make(compact('domains'), [
            'domains' => ['array', 'min:1'],
            'domains.*' => ['required', 'array', new AllowedAttributes(['name', 'default'])],
            'domains.*.name' => ['required', 'string'],
            'domains.*.default' => ['required', 'boolean'],
        ])->passes();
    }

    /**
     * @param array $domains
     * @return bool
     */
    protected function validDomains($domains)
    {
        $domains = collect($domains);

        if ($domains->pluck('name')->unique()->count() !== $domains->count()) {
            return false;
        }

        if ($domains->filter(fn($d) => $d['default'])->count() !== 1) {
            return false;
        }

        return Tenant::query()
                ->when($this->tenantId, fn($query) => $query->where('id', '!=', $this->tenantId))
                ->where(function ($query) use ($domains) {
                    foreach ($domains->pluck('name') as $name) {
                        $query->orWhereRaw('domains @> ?', ["[{\"name\": \"{$name}\"}]"]);
                    }
                })
                ->count() === 0;
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
