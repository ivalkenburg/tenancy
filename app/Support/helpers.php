<?php

namespace App\Support;

/**
 * @param string $permission
 * @param \App\Models\User|null $user
 * @return bool
 */
function can($permission, $user = null)
{
    $user = $user ?: auth()->user();

    return $user ? $user->hasPermissionTo($permission) : false;
}

/**
 * @param string $permission
 * @param \App\Models\User|null $user
 * @return bool
 */
function cannot($permission, $user = null)
{
    return !can($permission, $user);
}
