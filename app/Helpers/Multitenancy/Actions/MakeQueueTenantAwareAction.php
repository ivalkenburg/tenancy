<?php

namespace App\Helpers\Multitenancy\Actions;

use App\Helpers\Multitenancy\Models\Tenant;

class MakeQueueTenantAwareAction extends \Spatie\Multitenancy\Actions\MakeQueueTenantAwareAction
{
    /**
     * @param object $job
     * @return bool
     */
    protected function isTenantAware(object $job): bool
    {
        if (!Tenant::isMultitenancyEnabled()) {
            return false;
        }

        return parent::isTenantAware($job);
    }
}
