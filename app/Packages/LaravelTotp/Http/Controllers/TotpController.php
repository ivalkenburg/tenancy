<?php

namespace App\Packages\LaravelTotp\Http\Controllers;

use App\Packages\LaravelTotp\Authenticator;
use App\Packages\LaravelTotp\Rules\VerifyTotp;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class TotpController extends Controller
{
    const INTENDED_TOTP_SECRET = '_intended_totp_secret';

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     * @throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
     */
    public function enable(Request $request)
    {
        abort_if($request->user()->hasTotpEnabled(), Response::HTTP_FORBIDDEN);

        $intendedSecret = session(static::INTENDED_TOTP_SECRET, Authenticator::generateSecret());

        session()->flash(static::INTENDED_TOTP_SECRET, $intendedSecret);

        return $this->sendEnableResponse($request, $intendedSecret);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function confirm(Request $request)
    {
        abort_if($request->user()->hasTotpEnabled() || !session()->has(static::INTENDED_TOTP_SECRET), Response::HTTP_FORBIDDEN);

        $intendedSecret = session(static::INTENDED_TOTP_SECRET);

        $this->validateConfirmRequest($request, $intendedSecret);

        if (!$request->user()->setTotpSecret($intendedSecret)->save()) {
            session()->flash(static::INTENDED_TOTP_SECRET, $intendedSecret);

            throw ValidationException::withMessages([
                'verification_code' => 'Failed to enable two factor authentication',
            ]);
        }

        session()->forget(static::INTENDED_TOTP_SECRET);

        return $this->sendConfirmSuccessResponse($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Request $request)
    {
        abort_if(!$request->user()->hasTotpEnabled(), Response::HTTP_FORBIDDEN);

        $request->user()->disableTotp()->save();

        return $this->sendDisableResponse($request);
    }

    /**
     * @param Request $request
     * @param string $secret
     */
    protected function validateConfirmRequest(Request $request, $secret)
    {
        $validator = validator($request->only('verification_code'), [
            'verification_code' => ['required', 'string', 'digits:6', VerifyTotp::withSecret($secret)]
        ]);

        $validator->after(fn() => session()->flash(static::INTENDED_TOTP_SECRET, $secret));
        $validator->validate();
    }

    /**
     * @param Request $request
     * @param string $secret
     * @return \Illuminate\View\View
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     * @throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
     */
    protected function sendEnableResponse(Request $request, $secret)
    {
        return view('totp::enable', [
            'redirect' => $request->get('redirect'),
            'forced' => $request->boolean('forced'),
            'secret' => $secret,
            'qrCode' => $this->generateQrCode($secret),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendConfirmSuccessResponse(Request $request)
    {
        return redirect($request->get('redirect', '/'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendDisableResponse(Request $request)
    {
        return back();
    }

    /**
     * @param string $secret
     * @return string
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     * @throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
     */
    protected function generateQrCode($secret)
    {
        return app(config('totp.qr_code_generator'))->generate(
            urlencode(Authenticator::generateUri($this->getIssuer(), $this->getHolder(), $secret))
        );
    }

    /**
     * @return string
     */
    protected function getIssuer()
    {
        return config('app.name');
    }

    /**
     * @return string
     */
    protected function getHolder()
    {
        return auth()->user()->email;
    }
}
