<?php

namespace App\Models;

use App\Notifications\Landlord\ResetPasswordNotification;
use App\Packages\LaravelTotp\Contracts\TotpVerifiableContract;
use App\Packages\LaravelTotp\TotpVerifiable;
use App\Traits\UsesUuid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Landlord extends Authenticatable implements TotpVerifiableContract
{
    use UsesUuid, Notifiable, TotpVerifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param string $password
     * @return void
     */
    protected function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * @inheritDoc
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
