<?php

namespace App\Helpers\Tenancy\Middleware;

use App\Helpers\Tenancy\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantAware
{
    const VALID_TENANT_SESSION_KEY = '__tenant_id';

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!config('multitenancy.enable')) {
            return $next($request);
        }

        $currentTenantId = Tenant::currentId();

        abort_unless($currentTenantId, Response::HTTP_NOT_FOUND);

        if (!$request->session()->has(static::VALID_TENANT_SESSION_KEY)) {
            $request->session()->put(static::VALID_TENANT_SESSION_KEY, $currentTenantId);
        } elseif ($request->session()->get(static::VALID_TENANT_SESSION_KEY) !== $currentTenantId) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
