<?php

namespace App\Helpers\Multitenancy\Actions;

use App\Helpers\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;

class MakeTenantCurrentAction extends \Spatie\Multitenancy\Actions\MakeTenantCurrentAction
{
    /**
     * @param BaseTenant $tenant
     * @return MakeTenantCurrentAction
     */
    public function execute(BaseTenant $tenant)
    {
        if (Tenant::checkCurrent() && Tenant::currentId() !== $tenant->id) {
            Tenant::forgetCurrent();
        }

        return parent::execute($tenant);
    }
}
