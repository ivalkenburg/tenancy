<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * @inheritDoc
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return redirect()->back()->with('status', Password::RESET_LINK_SENT);
    }

    /**
     * @inheritDoc
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return $this->sendResetLinkResponse($request, $response);
    }
}
