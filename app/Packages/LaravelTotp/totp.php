<?php

return [

    /*
     * Login attempt listener.
     */
    'listener' => App\Packages\LaravelTotp\Listeners\EnforceTotpListener::class,

];
