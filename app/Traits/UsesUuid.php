<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UsesUuid
{
    /**
     * @return void
     */
    protected static function bootUsesUuid()
    {
        static::creating(fn($model) => $model->setUuid());
    }

    /**
     * @param bool $force
     * @return void
     */
    public function setUuid($force = false)
    {
        if ($this->getKey() && !$force) {
            return;
        }

        $this->{$this->getKeyName()} = (string)Str::uuid();
    }

    /**
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }
}
