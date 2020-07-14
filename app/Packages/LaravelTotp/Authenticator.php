<?php

namespace App\Packages\LaravelTotp;

use PragmaRX\Google2FA\Google2FA;

class Authenticator
{
    /** @var Google2FA */
    protected static $google2fa;

    /**
     * @param string $secret
     * @param string $code
     * @return bool|int
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     * @throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
     */
    public static function verify($secret, $code)
    {
        return static::google2fa()->verify($code, $secret);
    }

    /**
     * @param int $length
     * @return string
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     * @throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
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
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     * @throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
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
