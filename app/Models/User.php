<?php

namespace App\Models;

use App\Helpers\Tenancy\Traits\TenantAware;
use App\Traits\UsesUuid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, UsesUuid, TenantAware;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
