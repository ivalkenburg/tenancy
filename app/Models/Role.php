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

        static::addGlobalScope('tenant', function ($query) {
            $query->where(fn($query) => $query->where('tenant_id', Tenant::currentId())->orWhereNull('tenant_id'));
        });

        static::creating(function ($model) {
            return $model->tenant_id = Tenant::currentId();
        });

        static::retrieved(function ($model) {
            $model->makeHidden('tenant_id');
        });
    }
}
