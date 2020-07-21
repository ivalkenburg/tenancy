<?php

namespace App\Packages\LaravelTotp\Contracts;

interface QrCodeGeneratorContract
{
    /**
     * @param string $uri
     * @return string
     */
    public function generate($uri);
}
