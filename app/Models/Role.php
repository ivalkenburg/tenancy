<?php

namespace App\Models;

use App\Support\Multitenancy\Models\Tenant;
use App\Support\Multitenancy\Traits\TenantAware;
use App\Traits\UsesUuid;

class Role extends \Spatie\Permission\Models\Role
{
    use TenantAware, UsesUuid;

    /**
     * @return void
     */
    protected static function bootTenantAware()
    {
        if (!Tenant::isMultitenancyEnabled()) {
            return;
        }

        $tenantId = Tenant::currentId();

        static::addGlobalScope('tenant', function ($query) use ($tenantId) {
            $query->where(fn($query) => $query->where('tenant_id', $tenantId)->orWhereNull('tenant_id'));
        });

        static::creating(fn($model) => $model->tenant_id = $tenantId);
    }
}
