<?php

namespace App\Models;

use App\Notifications\User\ConfirmationNotification;
use App\Packages\LaravelTotp\Contracts\TotpVerifiableContract;
use App\Packages\LaravelTotp\TotpVerifiable;
use App\Support\Multitenancy\Traits\TenantAware;
use App\Traits\UsesUuid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements TotpVerifiableContract
{
    use Notifiable,
        UsesUuid,
        TenantAware,
        LogsActivity,
        TotpVerifiable,
        HasRoles;

    static protected $logOnlyDirty = true;

    static protected $logAttributes = [
        'name',
        'email',
    ];

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $attributes = ['confirmed' => true];

    /**
     * @inheritDoc
     */
    protected static function boot()
    {
        static::creating(function ($user) {
            if ($user->confirmed) {
                return;
            }

            $user->password = Str::random(32);
            $user->confirmation_token = Str::random(64);
        });

        static::created(function ($user) {
            if ($user->confirmed) {
                return;
            }

            $user->notify(new ConfirmationNotification);
        });

        parent::boot();
    }

    /**
     * @param string $password
     */
    protected function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
