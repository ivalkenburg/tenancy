<?php

namespace App\Support\Multitenancy;

use App\Support\Multitenancy\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;

class TenantFinder extends \Spatie\Multitenancy\TenantFinder\TenantFinder
{
    const TENANTS_CACHE_KEY = 'tenants';

    /**
     * @param Request $request
     * @return BaseTenant|null
     * @throws \Exception
     */
    public function findForRequest(Request $request): ?BaseTenant
    {
        // TODO: add multiple domain support

        return $this->getTenantByDomain($request->getHost());
    }

    /**
     * @param string $domain
     * @return BaseTenant|null
     * @throws \Exception
     */
    protected function getTenantByDomain($domain)
    {
        $tenant = unserialize(Cache::connection()->hget(static::TENANTS_CACHE_KEY, $domain));

        if ($tenant) {
            return $tenant;
        }

        $tenant = Tenant::where('domain', $domain)->first();

        if (!$tenant) {
            return null;
        }

        Cache::connection()->hset(static::TENANTS_CACHE_KEY, $domain, serialize($tenant));

        return $tenant;
    }
}
