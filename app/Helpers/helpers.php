<?php

namespace App\Helpers;

function can($permission, $user = null)
{
    $user = $user ?: auth()->user();

    return $user ? $user->hasPermissionTo($permission) : false;
}
