<?php

namespace App\Helpers\Multitenancy;

use App\Helpers\Multitenancy\Models\Tenant;
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
        // TODO: add caching
        // TODO: add multi domain

        return Tenant::where('domain', $request->getHost())->first();
    }
}
