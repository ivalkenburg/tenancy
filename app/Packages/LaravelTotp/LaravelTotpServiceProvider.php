<?php

namespace App\Packages\LaravelTotp;

use App\Packages\LaravelTotp\Contracts\EnforceTotpContract;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Validated;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class LaravelTotpServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'totp');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/totp.php' => config_path('totp.php'),
                __DIR__ . '/resources/views' => resource_path('views/vendor/totp'),
            ]);
        }
    }

    /**
     * @return void
     */
    public function register()
    {
        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/totp.php', 'totp');
        }

        $this->app->singleton(EnforceTotpContract::class, function ($app) {
            return new $app['config']['totp.listener']($app['config'], $app['request']);
        });

        $this->app['events']->listen(Attempting::class, EnforceTotpContract::class . '@saveCredentials');
        $this->app['events']->listen(Validated::class, EnforceTotpContract::class . '@validate');

        Router::macro('totp', function ($middleware = [], $prefix = 'totp', $namePrefix = '') {
            $this->group(compact('middleware', 'prefix'), function () use ($namePrefix) {
                $this->get('/enable', '\App\Packages\LaravelTotp\Http\Controllers\TotpController@enable')->name($namePrefix . 'totp.enable');
                $this->post('/enable', '\App\Packages\LaravelTotp\Http\Controllers\TotpController@confirm');
                $this->post('/disable', '\App\Packages\LaravelTotp\Http\Controllers\TotpController@disable')->name($namePrefix . 'totp.disable');
            });
        });
    }
}
