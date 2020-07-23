<?php

namespace App\Rules;

use App\Models\Role;
use Illuminate\Contracts\Validation\Rule;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Guard;

class RoleExists implements Rule
{
    protected $guard;

    /**
     * @param string|null $guard
     * @return static
     */
    public static function usingGuard($guard = null)
    {
        return new static($guard);
    }

    /**
     * @param string|null $guard
     */
    public function __construct($guard = null)
    {
        $this->guard = $guard ?: Guard::getDefaultName(Role::class);
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $roles = collect($value);
        $names = $roles->filter(fn($role) => !Uuid::isValid($role));
        $uuids = $roles->filter(fn($role) => Uuid::isValid($role));

        $count = Role::query()
            ->where('guard_name', $this->guard)
             ->when($names->isNotEmpty(), fn($query) => $query->whereIn('name', $names))
            ->when($uuids->isNotEmpty(), fn($query) => $query->whereIn('id', $uuids))
            ->count();

        return $count === (count($names) + count($uuids));
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'One or more roles do not exist.';
    }
}
