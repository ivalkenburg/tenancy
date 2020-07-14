<?php

return [

    /*
     * Enable TOTP authentication.
     */
    'enable' => true,

    /*
     * Login attempt listener.
     */
    'listener' => App\Packages\LaravelTotp\Listeners\EnforceTotpListener::class,

];
