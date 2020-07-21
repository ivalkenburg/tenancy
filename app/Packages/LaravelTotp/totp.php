<?php

return [

    /*
     * Login attempt listener.
     */

    'listener' => App\Packages\LaravelTotp\Listeners\EnforceTotpListener::class,

    /*
     * QR code generator.
     */

    'qr_code_generator' => App\Packages\LaravelTotp\QrCodeGenerator::class,
];
