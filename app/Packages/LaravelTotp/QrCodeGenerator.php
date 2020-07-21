<?php

namespace App\Packages\LaravelTotp;

use App\Packages\LaravelTotp\Contracts\QrCodeGeneratorContract;

class QrCodeGenerator implements QrCodeGeneratorContract
{
    /**
     * @inheritDoc
     */
    public function generate($uri)
    {
        return "https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl={$uri}";
    }
}
