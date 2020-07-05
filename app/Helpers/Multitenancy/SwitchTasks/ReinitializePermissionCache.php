<?php

namespace App\Helpers\Multitenancy\SwitchTasks;

use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;
use Spatie\Permission\PermissionRegistrar;

class ReinitializePermissionCache implements SwitchTenantTask
{
    /**
     * @param Tenant $tenant
     * @return void
     */
    public function makeCurrent(Tenant $tenant): void
    {
        app(PermissionRegistrar::class)->clearClassPermissions();
        app(PermissionRegistrar::class)->initializeCache();
    }

    /**
     * @return void
     */
    public function forgetCurrent(): void
    {
        app(PermissionRegistrar::class)->clearClassPermissions();
        app(PermissionRegistrar::class)->initializeCache();
    }
}
