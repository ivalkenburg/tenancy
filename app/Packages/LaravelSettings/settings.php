<?php

return [

    /*
     * Caching settings.
     */

    'caching' => [
        'enabled'   => true,
        'cache_key' => 'app_settings',
        'ttl'       => 60 * 60 * 24,
    ],

    /*
     * Used driver.
     */

    'store' => App\Packages\LaravelSettings\Stores\DatabaseStore::class,

    /*
     * Database store settings.
     */

    'database' => [
        'table' => 'settings',
        'key'   => 'key',
        'value' => 'value',
    ],

    /*
     * Default settings.
     */

    'defaults' => [],

];
