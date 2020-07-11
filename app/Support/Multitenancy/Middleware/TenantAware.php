<?php

namespace App\Support\Multitenancy\Middleware;

use App\Support\Multitenancy\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantAware
{
    const VALID_TENANT_SESSION_KEY = '_tenant_id';

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Tenant::isMultitenancyEnabled()) {
            return $next($request);
        }

        $currentTenantId = Tenant::currentId();

        abort_unless($currentTenantId, Response::HTTP_NOT_FOUND);

        if (!$request->session()->has(static::VALID_TENANT_SESSION_KEY)) {
            $request->session()->put(static::VALID_TENANT_SESSION_KEY, $currentTenantId);
        } elseif ($request->session()->get(static::VALID_TENANT_SESSION_KEY) !== $currentTenantId) {
            $request->session()->invalidate();
            abort(Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
