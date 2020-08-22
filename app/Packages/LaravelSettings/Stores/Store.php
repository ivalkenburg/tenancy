<?php

namespace App\Packages\LaravelSettings\Stores;

use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;

abstract class Store
{
    /** @var Application */
    protected $app;

    /** @var array */
    protected $settings = [];

    /** @var bool */
    protected $loaded = false;

    /** @var bool */
    protected $unsaved = false;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        return config('settings.caching.cache_key');
    }

    /**
     * @return $this
     */
    public function fresh()
    {
        $this->reset();

        return $this->clearCache();
    }

    /**
     * @return $this
     */
    public function clearCache()
    {
        $this->app['cache']->forget($this->getCacheKey());

        return $this;
    }

    /**
     * @return $this
     */
    public function reset()
    {
        $this->loaded   = false;
        $this->unsaved  = false;
        $this->settings = [];

        return $this;
    }

    /**
     * @return $this
     */
    public function saveAndReset()
    {
        $this->save();
        $this->reset();

        return $this;
    }

    /**
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key = null, $default = null)
    {
        $this->load();

        if (is_null($key)) {
            return $this->settings;
        }

        return Arr::get($this->settings, $key, $default);
    }

    /**
     * @param string|array|null $key
     * @return array
     */
    public function only($key = null)
    {
        $this->load();

        $results = [];
        $keys    = Arr::wrap($key);

        foreach ($keys as $key => $value) {
            if (is_string($key)) {
                if (!$value) {
                    continue;
                }
            } else {
                $key = $value;
            }

            if (!Arr::has($this->settings, $key)) {
                continue;
            }

            Arr::set($results, $key, Arr::get($this->settings, $key));
        }

        return $results;
    }

    /**
     * @param string|array|null $key
     * @return array
     */
    public function except($key = null)
    {
        $this->load();

        $results = $this->settings;

        Arr::forget($results, $key);

        return $results;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        $this->load();

        return Arr::has($this->settings, $key);
    }

    /**
     * @param string|array $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value = null)
    {
        $this->load();

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->set($k, $v);
            }
        } else {
            Arr::set($this->settings, $key, $value);
            $this->unsaved = true;
        }

        return $this;
    }

    /**
     * @param string|array $key
     * @return $this
     */
    public function forget($key)
    {
        $keys = Arr::wrap($key);

        foreach ($keys as $key) {
            if (!$this->has($key)) {
                continue;
            }

            Arr::forget($this->settings, $key);
            $this->unsaved = true;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (!$this->unsaved) {
            return false;
        }

        if ($this->write($this->settings)) {
            $this->clearCache();
            $this->unsaved = false;
        }

        return !$this->unsaved;
    }

    /**
     * @return bool
     */
    public function isUnsaved()
    {
        return $this->unsaved;
    }

    /**
     * @return bool
     */
    public function isLoaded()
    {
        return $this->loaded;
    }

    /**
     * @param bool $fresh
     * @return void
     */
    protected function load($fresh = false)
    {
        if ($this->loaded && !$fresh) {
            return;
        }

        $this->settings = config('settings.caching.enabled')
            ? $this->readCached($fresh)
            : $this->read();

        $this->loaded = true;
    }

    /**
     * @param bool $fresh
     * @return array
     */
    protected function readCached($fresh = false)
    {
        if ($fresh) {
            $this->clearCache();
        }

        return $this->app['cache']->remember($this->getCacheKey(), config('settings.caching.ttl'), function () {
            return $this->read();
        });
    }

    /**
     * @return array
     */
    protected function defaults() {
        return config('settings.defaults', []);
    }

    /**
     * @return bool
     */
    abstract public function prune();

    /**
     * @return array
     */
    abstract protected function read();

    /**
     * @param array $settings
     * @return bool
     */
    abstract protected function write($settings);
}
