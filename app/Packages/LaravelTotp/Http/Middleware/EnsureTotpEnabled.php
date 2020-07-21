<?php

namespace App\Packages\LaravelTotp\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureTotpEnabled
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (optional($request->user())->hasTotpEnabled() === false) {
            return redirect(route('totp.enable', ['forced' => true, 'redirect' => $request->fullUrl()]));
        }

        return $next($request);
    }
}
