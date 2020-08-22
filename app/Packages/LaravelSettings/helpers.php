<?php

use App\Packages\LaravelSettings\SettingsManager;

if (!function_exists('settings')) {
    /**
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function settings($key = null, $default = null) {
        /** @var SettingsManager $settings */
        $settings = app(SettingsManager::class);

        if (is_null($key)) {
            return $settings;
        }

        if (is_array($key)) {
            $settings->set($key);

            return $settings;
        }

        return $settings->get($key, $default);
    }
}
