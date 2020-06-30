<?php

namespace App\Helpers\Tenancy\Tasks;

use Illuminate\Support\Str;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;

class ChangeAppUrl implements SwitchTenantTask
{
    private $original;

    /**
     * @param Tenant $tenant
     * @return void
     */
    public function makeCurrent(Tenant $tenant): void
    {
        $this->original = config('app.url');

        $protocol = Str::before($this->original, '://');

        config()->set('app.url', "{$protocol}://{$tenant->domain}");
        url()->forceRootUrl(config('app.url'));
    }

    /**
     * @return void
     */
    public function forgetCurrent(): void
    {
        config()->set('app.url', $this->original);
        url()->forceRootUrl($this->original);
    }
}
