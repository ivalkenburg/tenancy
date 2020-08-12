<?php

namespace App\Packages\LaravelSettings\Stores;

use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;

class DatabaseStore extends Store
{
    /** @var \Illuminate\Database\Connection */
    protected $db;

    /** @var array */
    protected $config;

    /**
     * @inheritDoc
     */
    public function __construct(Application $app)
    {
        $this->db = $app['db']->connection();
        $this->config = $app['config']->get('settings.database');

        parent::__construct($app);
    }

    /**
     * @param bool $insert
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newQuery($insert = false)
    {
        return $this->db->table($this->config['table']);
    }

    /**
     * @inheritDoc
     */
    protected function read()
    {
        $flatData = $this->newQuery()->get();
        $results = $this->defaults();

        foreach ($flatData as $row) {
            Arr::set($results, $row->key, unserialize($row->value));
        }

        return $results;
    }

    /**
     * @inheritDoc
     */
    protected function write($settings)
    {
        $keys = $this->newQuery()->pluck($this->config['key']);
        $settings = Arr::dot($settings);
        $removed = [];

        foreach ($keys as $key) {
            if (array_key_exists($key, $settings)) {
                $this->newQuery()
                    ->where($this->config['key'], $key)
                    ->update([$this->config['value'] => serialize($settings[$key])]);
            } else {
                $removed[] = $key;
            }

            unset($settings[$key]);
        }

        if (!empty($removed)) {
            $this->newQuery()->whereIn($this->config['key'], $removed)->delete();
        }

        if (!empty($settings)) {
            $this->newQuery(true)->insert($this->settingsToInserts($settings));
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function prune()
    {
        return $this->newQuery()->delete() > 0;
    }

    /**
     * @param array $settings
     * @return array
     */
    protected function settingsToInserts($settings)
    {
        $additional = $this->mergedWithInserts();
        $inserts = [];

        foreach ($settings as $key => $value) {
            $inserts[] = array_merge([
                $this->config['key'] => $key,
                $this->config['value'] => serialize($value)
            ], $additional);
        }

        return $inserts;
    }

    /**
     * @return array
     */
    protected function mergedWithInserts()
    {
        return [];
    }
}
