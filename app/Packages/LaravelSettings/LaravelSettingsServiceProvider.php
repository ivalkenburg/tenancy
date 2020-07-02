<?php

namespace App\Packages\LaravelSettings;

use Illuminate\Support\ServiceProvider;

class LaravelSettingsServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/settings.php' => config_path('settings.php')]);
        }
    }

    /**
     * @return void
     */
    public function register()
    {
        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/settings.php', 'settings');
        }

        $this->app->singleton(SettingsManager::class);
    }
}
