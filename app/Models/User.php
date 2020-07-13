<?php

namespace App\Models;

use App\Support\Multitenancy\Traits\TenantAware;
use App\Traits\UsesUuid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,
        UsesUuid,
        TenantAware,
        LogsActivity,
        HasRoles;

    static protected $logOnlyDirty = true;

    static protected $logAttributes = [
        'name',
        'email',
    ];

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param string $password
     */
    protected function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
