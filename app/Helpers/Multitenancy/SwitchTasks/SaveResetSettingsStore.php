<?php

namespace App\Helpers\Multitenancy\SwitchTasks;

use App\Packages\LaravelSettings\Facades\Settings;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;

class SaveResetSettingsStore implements SwitchTenantTask
{
    /**
     * @param Tenant $tenant
     * @return void
     */
    public function makeCurrent(Tenant $tenant): void
    {
        Settings::saveAndReset();
    }

    /**
     * @return void
     */
    public function forgetCurrent(): void
    {
        Settings::saveAndReset();
    }
}
