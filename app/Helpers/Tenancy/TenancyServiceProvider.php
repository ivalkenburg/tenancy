<?php

namespace App\Helpers\Tenancy;

use Spatie\Multitenancy\MultitenancyServiceProvider;

class TenancyServiceProvider extends MultitenancyServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        if (!config('multitenancy.enable')) {
            return;
        }

        parent::boot();
    }
}
