<?php

namespace App\Support\Multitenancy\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Domains implements CastsAttributes
{
    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return new \App\Support\Multitenancy\Domains(json_decode($value, true));
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return json_encode($value instanceof \App\Support\Multitenancy\Domains ? $value->toArray() : $value);
    }
}
