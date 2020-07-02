<?php

namespace App\Packages\LaravelSettings\Http\Middleware;

use App\Packages\LaravelSettings\SettingsManager;
use Closure;
use Illuminate\Http\Request;

class SaveUnsavedSettings
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        app(SettingsManager::class)->save();

        return $response;
    }
}
