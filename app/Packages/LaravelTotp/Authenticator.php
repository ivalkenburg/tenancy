<?php

namespace App\Packages\LaravelTotp;

use Illuminate\Support\Traits\Macroable;
use PragmaRX\Google2FA\Google2FA;

class Authenticator
{
    use Macroable;

    /** @var Google2FA */
    protected static $google2fa;

    /**
     * @param string $secret
     * @param string $code
     * @return bool|int
     * @throws \Exception
     */
    public static function verify($secret, $code)
    {
        return static::google2fa()->verify($code, $secret);
    }

    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public static function generateSecret($length = 32)
    {
        return static::google2fa()->generateSecretKey($length);
    }

    /**
     * @param string $issuer
     * @param string $holder
     * @param string|null $secret
     * @return string
     * @throws \Exception
     */
    public static function generateUri($issuer, $holder, $secret = null)
    {
        $secret = $secret ?: static::generateSecret();

        return static::google2fa()->getQRCodeUrl($issuer, $holder, $secret);
    }

    /**
     * @return Google2FA
     */
    protected static function google2fa()
    {
        if (!isset(static::$google2fa)) {
            static::$google2fa = new Google2FA;
        }

        return static::$google2fa;
    }
}
