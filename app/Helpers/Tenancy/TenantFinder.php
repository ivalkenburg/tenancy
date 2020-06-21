<?php

namespace App\Helpers\Tenancy;

use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Tenant;

class TenantFinder extends \Spatie\Multitenancy\TenantFinder\TenantFinder
{
    /**
     * @param Request $request
     * @return Tenant|null
     */
    public function findForRequest(Request $request): ?Tenant
    {
        if (!config('multitenancy.enable')) {
            return null;
        }

        return Models\Tenant::whereDomain($request->getHost())->first();
    }
}
