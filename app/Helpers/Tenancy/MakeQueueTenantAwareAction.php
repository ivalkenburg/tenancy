<?php

namespace App\Helpers\Tenancy;

use Spatie\Multitenancy\Jobs\NotTenantAware;
use Spatie\Multitenancy\Jobs\TenantAware;

class MakeQueueTenantAwareAction extends \Spatie\Multitenancy\Actions\MakeQueueTenantAwareAction
{
    /**
     * @param object $job
     * @return bool
     */
    protected function isTenantAware(object $job): bool
    {
        if (!config('multitenancy.enable')) {
            return false;
        }

        return parent::isTenantAware($job);
    }
}
