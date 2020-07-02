<?php

namespace App\Helpers\Multitenancy;

use App\Helpers\Multitenancy\Models\Tenant;
use App\Packages\LaravelSettings\Stores\DatabaseStore;

class TenantAwareDatabaseSettingsStore extends DatabaseStore
{
    /**
     * @param bool $insert
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newQuery($insert = false)
    {
        $query = parent::newQuery($insert);

        if (!Tenant::isMultitenancyEnabled()) {
            return $query;
        }

        return $insert ? $query : $query->where(fn($query) => $query->where('tenant_id', Tenant::currentId()));
    }

    /**
     * @return array
     */
    protected function mergedWithInserts() {
        return Tenant::isMultitenancyEnabled() ? ['tenant_id' => Tenant::currentId()] : [];
    }
}
