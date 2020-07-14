<?php

namespace App\Packages\LaravelTotp;

use App\Packages\LaravelTotp\Contracts\EnforceTotpContract;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\ServiceProvider;

class LaravelTotpServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/totp.php', 'totp');
        }

        $this->loadViewsFrom(__DIR__.'/views', 'totp');
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EnforceTotpContract::class, function ($app) {
            return new $app['config']['totp.listener']($app['config'], $app['request']);
        });

        $this->app['events']->listen(Attempting::class, EnforceTotpContract::class . '@saveCredentials');
        $this->app['events']->listen(Validated::class, EnforceTotpContract::class . '@validate');
    }
}
