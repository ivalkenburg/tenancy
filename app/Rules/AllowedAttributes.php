<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AllowedAttributes implements Rule
{
    /** @var array */
    protected $allowed;

    /** @var bool */
    protected $strict;

    /**
     * @param array $allowed
     * @param bool $strict
     */
    public function __construct($allowed = [], $strict = true)
    {
        $this->allowed = $allowed;
        $this->strict = $strict;
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        if (!is_array($value)) {
            return false;
        }

        $keys = array_keys($value);

        foreach($keys as $key) {
            if (!in_array($key, $this->allowed)) {
                return false;
            }
        }

        if ($this->strict && count($keys) !== count($this->allowed)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'Attributes do meet the given requirement.';
    }
}
