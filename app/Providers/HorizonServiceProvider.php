<?php

namespace App\Providers;

use App\Support\Multitenancy\Models\Tenant;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Laravel\Horizon\Horizon;

class HorizonServiceProvider extends \Laravel\Horizon\HorizonServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->setupAuthorization();

        parent::boot();
    }

    /**
     * @return void
     */
    protected function setupAuthorization()
    {
        Horizon::auth(function ($request) {
            return app()->environment('local')
                || Gate::check('viewHorizon', [$request->user()]);
        });

        Gate::define('viewHorizon', function ($user) {
            return true;
        });
    }

    /**
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group([
            'domain' => Tenant::isMultitenancyEnabled() ? config('multitenancy.landlord_domain') : null,
            'prefix' => config('horizon.path'),
            'namespace' => 'Laravel\Horizon\Http\Controllers',
            'middleware' => config('horizon.middleware', 'web'),
        ], function () {
            $this->loadRoutesFrom(base_path('/vendor/laravel/horizon/routes/web.php'));
        });
    }
}
