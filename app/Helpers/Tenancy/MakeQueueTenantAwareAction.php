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

        if ($job instanceof TenantAware) {
            return true;
        }

        if (config('multitenancy.queues_are_tenant_aware_by_default') && $job instanceof NotTenantAware) {
            return false;
        }

        if (!config('multitenancy.queues_are_tenant_aware_by_default')) {
            return false;
        }

        return true;
    }
}
