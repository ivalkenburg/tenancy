<?php

namespace App\Support\Multitenancy\SwitchTasks;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
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

        Config::set('app.url', "{$protocol}://{$tenant->domains->default()}");
        URL::forceRootUrl(config('app.url'));
    }

    /**
     * @return void
     */
    public function forgetCurrent(): void
    {
        Config::set('app.url', $this->original);
        URL::forceRootUrl($this->original);
    }
}
