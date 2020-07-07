<?php

namespace App\Support\Multitenancy;

use App\Support\Multitenancy\Models\Tenant;
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
        // TODO: add multiple domain support

        return Tenant::where('domain', $request->getHost())->first();
    }
}
