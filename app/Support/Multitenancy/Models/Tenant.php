<?php

namespace App\Support\Multitenancy\Models;

use App\Support\Multitenancy\TenantFinder;
use App\Traits\UsesUuid;
use Illuminate\Support\Facades\Redis;

class Tenant extends \Spatie\Multitenancy\Models\Tenant
{
    use UsesUuid;

    protected static $multitenancyEnabled;

    protected $guarded = [];

    /**
     * @inheritDoc
     */
    protected static function boot()
    {
        static::updating(fn($tenant) => $tenant->clearCached());
        static::deleted(fn($tenant) => $tenant->clearCached());

        parent::boot();
    }

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
            static::$multitenancyEnabled = (bool)config('multitenancy.enable');
        }

        return static::$multitenancyEnabled;
    }

    /**
     * @param string $path
     * @param bool $secure
     * @return string
     */
    public function url($path = null, $secure = true)
    {
        return ($secure ? 'https://' : 'http://') . trim($this->domain, '/') . '/' . trim($path ?? '', '/');
    }

    /**
     * @return $this
     */
    public function clearCached()
    {
        Redis::hdel(TenantFinder::TENANTS_CACHE_KEY, md5($this->getOriginal('domain')));

        return $this;
    }
}
