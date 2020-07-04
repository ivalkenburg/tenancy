<?php

namespace App\Models;

use App\Helpers\Multitenancy\Models\Tenant;
use App\Helpers\Multitenancy\Traits\TenantAware;
use App\Traits\UsesUuid;

class Role extends \Spatie\Permission\Models\Role
{
    use TenantAware, UsesUuid;

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
