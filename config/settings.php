<?php

return [

    /*
     * Caching settings.
     */

    'caching' => [
        'enabled' => true,
        'cache_key' => 'settings',
        'ttl' => 60 * 60 * 24,
    ],

    /*
     * Used store.
     */

    'store' => App\Helpers\Multitenancy\TenantAwareDatabaseSettingsStore::class,

    /*
     * Database store settings.
     */

    'database' => [
        'table' => 'settings',
        'key' => 'key',
        'value' => 'value',
    ],

    /*
     * Default settings
     */

    'defaults' => [],

];
