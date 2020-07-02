<?php

namespace App\Packages\LaravelSettings\Facades;

use App\Packages\LaravelSettings\SettingsManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Packages\LaravelSettings\Stores\Store store()
 * @method static \App\Packages\LaravelSettings\Stores\Store clearCache()
 * @method static \App\Packages\LaravelSettings\Stores\Store reset()
 * @method static \App\Packages\LaravelSettings\Stores\Store saveAndReset()
 * @method static mixed get(string|null $key = null, mixed $default = null)
 * @method static array only(string|array|null $key = null)
 * @method static array except(string|array|null $key = null)
 * @method static bool has(string $key)
 * @method static \App\Packages\LaravelSettings\Stores\Store set(string|array $key, mixed $value = null)
 * @method static \App\Packages\LaravelSettings\Stores\Store forget(string|array $key)
 * @method static bool prune()
 * @method static bool save()
 * @method static bool isUnsaved()
 */
class Settings extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SettingsManager::class;
    }
}
