<?php

namespace App\Packages\LaravelTotp\Rules;

use App\Packages\LaravelTotp\Authenticator;
use Illuminate\Contracts\Validation\Rule;

class VerifyTotp implements Rule
{
    protected $totpSecret;

    /**
     * @param $user
     * @return static
     */
    public static function withUser($user)
    {
        return new static($user->getTotpSecret());
    }

    /**
     * @param string $secret
     * @return static
     */
    public static function withSecret($secret)
    {
        return new static($secret);
    }

    /**
     * @param string $totpSecret
     */
    public function __construct($totpSecret)
    {
        $this->totpSecret = $totpSecret;
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        try {
            return $this->verify($value);
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param string $code
     * @return bool|int
     * @throws \Exception
     */
    public function verify($code)
    {
        if (!is_string($code) || empty($code)) {
            return false;
        }

        return Authenticator::verify($this->totpSecret, $code);
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'The :attribute is incorrect.';
    }
}
