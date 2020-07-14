<?php

namespace App\Packages\LaravelTotp\Contracts;

interface TotpVerifiableContract
{
    /**
     * @return bool
     */
    public function hasTotpEnabled();

    /**
     * @param string $secret
     * @return $this
     */
    public function setTotpSecret($secret);

    /**
     * @return $this
     */
    public function disableTotp();

    /**
     * @return string|null
     */
    public function getTotpSecret();

    /**
     * @param string $code
     * @return bool
     */
    public function validTotpCode($code);
}
