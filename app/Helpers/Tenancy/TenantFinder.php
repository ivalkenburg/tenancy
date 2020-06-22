<?php

namespace App\Helpers\Tenancy;

use App\Helpers\Tenancy\Models\Tenant;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;

class TenantFinder extends \Spatie\Multitenancy\TenantFinder\TenantFinder
{
    /**
     * @param Request $request
     * @return BaseTenant|null
     */
    public function findForRequest(Request $request): ?BaseTenant
    {
        return Tenant::whereDomain($request->getHost())->first();
    }
}
