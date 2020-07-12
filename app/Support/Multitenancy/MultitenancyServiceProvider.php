<?php

namespace App\Support\Multitenancy;

use App\Support\Multitenancy\Models\Tenant;

class MultitenancyServiceProvider extends \Spatie\Multitenancy\MultitenancyServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        if (!Tenant::isMultitenancyEnabled()) {
            return;
        }

        $this
            ->registerTenantFinder()
            ->registerTasksCollection()
            ->configureRequests()
            ->configureQueue();
    }
}
