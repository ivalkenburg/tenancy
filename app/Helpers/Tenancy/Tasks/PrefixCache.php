<?php

namespace App\Helpers\Tenancy\Tasks;

use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;

class PrefixCache implements SwitchTenantTask
{
    protected $original;

    /**
     * @param Tenant $tenant
     * @throws \Exception
     */
    public function makeCurrent(Tenant $tenant): void
    {
        $this->original = config('cache.prefix');

        config()->set('cache.prefix', str_replace($tenant->id, '-', ''));

        cache()->forgetDriver();
    }

    /**
     * @throws \Exception
     */
    public function forgetCurrent(): void
    {
        config()->set('cache.prefix', $this->original);

        cache()->forgetDriver();
    }
}
