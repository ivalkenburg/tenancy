<?php

namespace App\Providers;

use App\Helpers\Multitenancy\Models\Tenant;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    const HOME = '/home';

    /**
     * @return void
     */
    public function map()
    {
        $this->mapLandlordRoutes();
        $this->mapWebRoutes();
    }

    /**
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware(['web', 'tenant.aware'])
            ->namespace('App\Http\Controllers')
            ->group(base_path('routes/web.php'));
    }

    /**
     * @return void
     */
    protected function mapLandlordRoutes()
    {
        if (!Tenant::isMultitenancyEnabled()) {
            return;
        }

        Route::domain(config('multitenancy.landlord_domain'))
            ->middleware('web')
            ->namespace('App\Http\Controllers\Landlord')
            ->group(base_path('routes/landlord.php'));
    }
}
