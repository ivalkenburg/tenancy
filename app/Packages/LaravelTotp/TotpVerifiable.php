<?php

namespace App\Packages\LaravelTotp;

trait TotpVerifiable
{
    /**
     * @return void
     */
    protected static function bootTotpVerifiable()
    {
        static::retrieved(fn($verifiable) => $verifiable->makeHidden('totp_secret'));
    }

    /**
     * @return bool
     */
    public function hasTotpEnabled()
    {
        return (bool)$this->totp_secret;
    }

    /**
     * @param string $secret
     * @return TotpVerifiable
     */
    public function setTotpSecret($secret)
    {
        $this->totp_secret = encrypt($secret);

        return $this;
    }

    /**
     * @return $this
     */
    public function disableTotp()
    {
        $this->totp_secret = null;

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
     * @throws \Exception
     */
    public function verifyTotpCode($code)
    {
        if (!$this->hasTotpEnabled()) {
            throw new \Exception('Unable to verify code; no secret is set.');
        }

        return Authenticator::verify($this->getTotpSecret(), $code);
    }
}
