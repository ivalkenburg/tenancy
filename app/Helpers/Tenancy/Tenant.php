<?php

namespace App\Helpers\Tenancy;

use App\Traits\UsesUuid;

class Tenant extends \Spatie\Multitenancy\Models\Tenant
{
    use UsesUuid;

    /**
     * @return string|null
     */
    public static function currentId()
    {
        return optional(static::current())->getKey();
    }
}
