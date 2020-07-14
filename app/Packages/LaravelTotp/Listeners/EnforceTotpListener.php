<?php

namespace App\Packages\LaravelTotp\Listeners;

use App\Packages\LaravelTotp\Contracts\EnforceTotpContract;
use App\Packages\LaravelTotp\Contracts\TotpVerifiableContract;
use App\Packages\LaravelTotp\Rules\VerifyTotp;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Validated;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;

class EnforceTotpListener implements EnforceTotpContract
{
    const CODE_INPUT_NAME = 'verification_code';

    /** @var Request */
    protected $request;

    /** @var Repository */
    protected $config;

    /** @var array */
    protected $credentials;

    /** @var bool */
    protected $remember;

    /** @var string */
    protected $guard;

    /**
     * @inheritDoc
     */
    public function __construct(Repository $config, Request $request)
    {
        $this->config = $config;
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public function saveCredentials(Attempting $event)
    {
        $this->credentials = $event->credentials;
        $this->remember = $event->remember;
        $this->guard = $event->guard;
    }

    /**
     * @inheritDoc
     */
    public function validate(Validated $event)
    {
        /** @var TotpVerifiableContract $user */
        $user = $event->user;

        if ($user->hasTotpEnabled()) {
            if ($this->requestContainsCode() && !$invalid = $this->requestHasInvalidCode($user)) {
                return;
            }

            $this->throwResponse($user, isset($invalid));
        }
    }

    /**
     * @return bool
     */
    protected function requestContainsCode()
    {
        return $this->request->has(static::CODE_INPUT_NAME);
    }

    /**
     * @param TotpVerifiableContract $user
     * @return bool
     */
    protected function requestHasInvalidCode(TotpVerifiableContract $user)
    {
        return validator($this->request->only(static::CODE_INPUT_NAME), [
            static::CODE_INPUT_NAME => ['required', 'string', 'digits:6', VerifyTotp::withUser($user)]
        ])->fails();
    }

    /**
     * @param TotpVerifiableContract $user
     * @param bool $error
     */
    protected function throwResponse(TotpVerifiableContract $user, $error)
    {
        $view = view('totp::verify', [
            'user' => $user,
            'action' => $this->request->fullUrl(),
            'credentials' => $this->credentials,
            'guard' => $this->guard,
            'codeInputName' => static::CODE_INPUT_NAME,
            'remember' => $this->remember,
            'error' => $error,
        ]);

        response($view)->throwResponse();
    }
}
