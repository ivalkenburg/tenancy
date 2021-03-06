<?php

namespace App\Support\Multitenancy\Traits;

use App\Support\Multitenancy\Models\Tenant;
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

        static::addGlobalScope('tenant', function ($query) {
            $query->where(fn($query) => $query->where('tenant_id', Tenant::currentId()));
        });

        static::creating(function ($model) {
            $model->tenant_id = Tenant::currentId();
        });

        static::retrieved(function ($model) {
            $model->makeHidden('tenant_id');
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
