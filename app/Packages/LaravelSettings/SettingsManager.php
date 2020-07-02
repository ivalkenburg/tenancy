<?php

namespace App\Packages\LaravelSettings;

use App\Packages\LaravelSettings\Stores\Store;

class SettingsManager
{
    /** @var \Illuminate\Foundation\Application */
    protected $app;

    /** @var Store */
    protected $store;

    /**
     * @param \Illuminate\Foundation\Application|null $app
     */
    public function __construct($app = null)
    {
        $this->app = $app ?: app();
    }

    /**
     * @return Store
     * @throws \Exception
     */
    protected function instantiateStore()
    {
        $store = config('settings.store');

        if (!class_exists($store)) {
            throw new \RuntimeException("Laravel Settings store [$store] does not exist");
        }

        return new $store($this->app);
    }

    /**
     * @return Store
     * @throws \Exception
     */
    public function store()
    {
        if (!isset($this->store)) {
            $this->store = $this->instantiateStore();
        }

        return $this->store;
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function __call($method, $parameters)
    {
        return $this->store()->$method(...$parameters);
    }
}
