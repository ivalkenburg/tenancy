<?php

namespace App\Helpers\Tenancy\Rules;

use App\Helpers\Tenancy\Models\Tenant;

class Unique extends \Illuminate\Validation\Rules\Unique
{
    /**
     * @param string $table
     * @param string $column
     * @return static
     */
    static public function on($table, $column = 'NULL')
    {
        return new static($table, $column);
    }

    /**
     * @param string $table
     * @param string $column
     */
    public function __construct($table, $column = 'NULL')
    {
        parent::__construct($table, $column);

        if (config('multitenancy.enable')) {
            $this->where('tenant_id', Tenant::currentId());
        }
    }
}
