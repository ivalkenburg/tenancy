<?php

namespace App\Helpers\Tenancy;

trait TenantAware
{
    protected static function bootTenantAware()
    {
        if (!config('app.tenant_aware')) {
            return;
        }

        $tenantId = Tenant::currentId();

        static::addGlobalScope('tenant', function ($query) use ($tenantId) {
            $query->where('tenant_id', $tenantId);
        });

        static::creating(function ($model) use ($tenantId) {
            $model->tenant_id = $tenantId;
        });
    }

    public function tenant()
    {
        return $this->belongsTo(config('multitenancy.tenant_model'), 'tenant_id');
    }
}
