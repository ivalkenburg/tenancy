<?php

namespace App\Packages\LaravelTotp;

trait TotpVerifiable
{
    /**
     * @return void
     */
    protected static function bootTotpVerifiable()
    {
        static::retrieved(fn ($verifiable) => $verifiable->makeHidden('totp_secret'));
    }

    /**
     * @return bool
     */
    public function hasTotpEnabled()
    {
        return (bool) $this->totp_secret;
    }

    /**
     * @param string $secret
     * @return TotpVerifiable
     */
    public function setTotpSecret($secret = null)
    {
        $this->totp_secret = $secret ? encrypt($secret) : null;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTotpSecret()
    {
        return $this->totp_secret ? decrypt($this->totp_secret) : null;
    }

    /**
     * @param int $code
     * @return bool
     */
    public function validTotpCode($code)
    {
        return true;
    }
}
