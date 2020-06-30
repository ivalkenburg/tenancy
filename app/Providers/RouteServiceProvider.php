<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapLandlordRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware(['web', 'tenant.aware'])
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * @return void
     */
    protected function mapLandlordRoutes()
    {
        if (!config('multitenancy.enable')) {
            return;
        }

        Route::domain(config('multitenancy.landlord_domain'))
            ->middleware('web')
            ->namespace($this->namespace . '\Landlord')
            ->group(base_path('routes/landlord.php'));
    }
}
