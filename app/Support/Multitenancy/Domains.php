<?php

namespace App\Support\Multitenancy;

use Illuminate\Contracts\Support\Arrayable;

class Domains implements Arrayable, \JsonSerializable, \ArrayAccess
{
    protected $domains;

    /**
     * @param array $domains
     */
    public function __construct($domains = [])
    {
        $this->domains = $domains;
    }

    /**
     * @return string
     */
    public function default()
    {
        foreach ($this->domains as $domain) {
            if ($domain['default']) {
                return $domain['name'];
            }
        }

        return $this->domains[0]['name'] ?? null;
    }

    /**
     * @param string $name
     * @return $this
     * @throws \Exception
     */
    public function setDefault($name)
    {
        if (!$this->has($name)) {
            throw new \Exception("Domain [{$name}] does not exist.");
        }

        foreach($this->domains as &$domain) {
            $domain['default'] = $domain['name'] === $name;
        }

        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        foreach($this->domains as $domain) {
            if ($domain['name'] === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function each($callback)
    {
        foreach ($this->domains as $domain) {
            $callback($domain);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return $this->domains;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->domains;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->domains[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->domains[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->domains[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->domains[$offset]);
    }
}
