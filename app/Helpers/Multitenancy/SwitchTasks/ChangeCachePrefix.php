<?php

namespace App\Helpers\Multitenancy\SwitchTasks;

use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;

class ChangeCachePrefix implements SwitchTenantTask
{
    protected $original;
    protected $driver;

    /**
     * @param Tenant $tenant
     * @return void
     */
    public function makeCurrent(Tenant $tenant): void
    {
        $this->original = config('cache.prefix');
        $this->driver = config('cache.default');

        config()->set('cache.prefix', str_replace('-', '', $tenant->id));
        app('cache')->forgetDriver($this->driver);
    }

    /**
     * @return void
     */
    public function forgetCurrent(): void
    {
        config()->set('cache.prefix', $this->original);
        app('cache')->forgetDriver($this->driver);
    }
}
