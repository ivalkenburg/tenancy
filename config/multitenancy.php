<?php

return [

    /*
     * Turn off tenant awareness.
     */
    'enable' => env('TENANCY_ENABLE'),

    /*
     * Landlord domain.
     */
    'landlord_domain' => env('TENANCY_LANDLORD_DOMAIN', 'landlord.localhost'),

    /*
     * This class is responsible for determining which tenant should be current
     * for the given request.
     *
     * This class should extend `Spatie\Multitenancy\TenantFinder\TenantFinder`
     *
     */
    'tenant_finder' => App\Helpers\Multitenancy\TenantFinder::class,

    /*
     * These tasks will be performed when switching tenants.
     *
     * A valid task is any class that implements Spatie\Multitenancy\Tasks\SwitchTenantTask
     */
    'switch_tenant_tasks' => [
        App\Helpers\Multitenancy\SwitchTasks\ChangeCachePrefix::class,
        App\Helpers\Multitenancy\SwitchTasks\ChangeAppUrl::class,
        App\Helpers\Multitenancy\SwitchTasks\SaveResetSettingsStore::class,
        App\Helpers\Multitenancy\SwitchTasks\ReinitializePermissionCache::class,
    ],

    /*
     * This class is the model used for storing configuration on tenants.
     *
     * It must be or extend `Spatie\Multitenancy\Models\Tenant::class`
     */
    'tenant_model' => App\Helpers\Multitenancy\Models\Tenant::class,

    /*
     * If there is a current tenant when dispatching a job, the id of the current tenant
     * will be automatically set on the job. When the job is executed, the set
     * tenant on the job will be made current.
     */
    'queues_are_tenant_aware_by_default' => true,

    /*
     * The connection name to reach the tenant database.
     *
     * Set to `null` to use the default connection.
     */
    'tenant_database_connection_name' => null,

    /*
     * The connection name to reach the landlord database
     */
    'landlord_database_connection_name' => null,

    /*
     * This key will be used to bind the current tenant in the container.
     */
    'current_tenant_container_key' => 'current_tenant',

    /*
     * You can customize some of the behavior of this package by using our own custom action.
     * Your custom action should always extend the default one.
     */
    'actions' => [
        'make_tenant_current_action' => App\Helpers\Multitenancy\Actions\MakeTenantCurrentAction::class,
        'forget_current_tenant_action' => Spatie\Multitenancy\Actions\ForgetCurrentTenantAction::class,
        'make_queue_tenant_aware_action' => App\Helpers\Multitenancy\Actions\MakeQueueTenantAwareAction::class,
        'migrate_tenant' => Spatie\Multitenancy\Actions\MigrateTenantAction::class,
    ],
];
