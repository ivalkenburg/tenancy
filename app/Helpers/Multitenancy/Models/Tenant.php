<?php

namespace App\Helpers\Multitenancy\Models;

use App\Traits\UsesUuid;

class Tenant extends \Spatie\Multitenancy\Models\Tenant
{
    use UsesUuid;

    protected static $multitenancyEnabled;

    protected $guarded = [];

    /**
     * @return string|null
     */
    public static function currentId()
    {
        return optional(static::current())->getKey();
    }

    /**
     * @return bool
     */
    public static function isMultitenancyEnabled()
    {
        if (!isset(static::$multitenancyEnabled)) {
            static::$multitenancyEnabled = (bool) config('multitenancy.enable');
        }

        return static::$multitenancyEnabled;
    }
}
