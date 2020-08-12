<?php

namespace App\Support\Multitenancy\Models;

use App\Support\Multitenancy\Casts\Domains;
use App\Support\Multitenancy\TenantFinder;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class Tenant extends \Spatie\Multitenancy\Models\Tenant
{
    use UsesUuid;

    protected static $multitenancyEnabled;

    protected $guarded = [];

    protected $casts = [
        'domains' => Domains::class,
    ];

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
     * @param Builder $query
     * @param string $name
     * @return Builder
     */
    protected function scopeByDomain($query, $name)
    {
        return $query->whereRaw('domains @> ?', ["[{\"name\": \"{$name}\"}]"]);
    }

    /**
     * @param string|null $path
     * @param bool $secure
     * @return string
     */
    public function url($path = null, $secure = true)
    {
        return ($secure ? 'https://' : 'http://') . trim($this->domains->default(), '/') . '/' . trim($path ?? '', '/');
    }

    /**
     * @return $this
     */
    public function clearCached()
    {
        foreach ($this->getOriginal('domains')->toArray() as $domain) {
            Cache::connection()->hdel(TenantFinder::TENANTS_CACHE_KEY, $domain['name']);
        }

        return $this;
    }
}
