<?php

namespace App\Helpers\Multitenancy\Traits;

use App\Helpers\Multitenancy\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait TenantAware
{
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
            $query->where(fn($query) => $query->where('tenant_id', $tenantId));
        });

        static::creating(function ($model) use ($tenantId) {
            $model->tenant_id = $tenantId;
        });
    }

    /**
     * @return BelongsTo
     */
    public function tenant()
    {
        return $this->belongsTo(config('multitenancy.tenant_model'), 'tenant_id');
    }

    /**
     * @param Builder $query
     * @param Model $tenant
     * @return Builder
     */
    public function scopeByTenant($query, $tenant)
    {
        if (!Tenant::isMultitenancyEnabled()) {
            return $query;
        }

        return $query->withoutGlobalScope('tenant')->where(
            'tenant_id', $tenant instanceof Model ? $tenant->id : $tenant
        );
    }
}
