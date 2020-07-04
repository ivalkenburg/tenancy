<?php

namespace App\Helpers\Multitenancy\SwitchTasks;

use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;
use Spatie\Permission\PermissionRegistrar;

class ReinitializePermissionCache implements SwitchTenantTask
{
    public function makeCurrent(Tenant $tenant): void
    {
        app(PermissionRegistrar::class)->clearClassPermissions();
        app(PermissionRegistrar::class)->initializeCache();
    }

    public function forgetCurrent(): void
    {
        app(PermissionRegistrar::class)->clearClassPermissions();
        app(PermissionRegistrar::class)->initializeCache();
    }
}
