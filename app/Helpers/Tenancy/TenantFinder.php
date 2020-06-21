<?php

namespace App\Helpers\Tenancy;

use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;
use Spatie\Multitenancy\Models\Tenant;

class TenantFinder extends \Spatie\Multitenancy\TenantFinder\TenantFinder
{
    use UsesTenantModel;

    /**
     * @param Request $request
     * @return Tenant|null
     */
    public function findForRequest(Request $request): ?Tenant
    {
        if (!config('app.tenant_aware')) {
            return null;
        }

        return $this->getTenantModel()->whereDomain($request->getHost())->first();
    }
}
