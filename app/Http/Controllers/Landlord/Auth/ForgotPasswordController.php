<?php

namespace App\Http\Controllers\Landlord\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest:landlord');
    }

    /**
     * @inheritDoc
     */
    public function showLinkRequestForm()
    {
        return view('landlord.auth.passwords.email');
    }

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

    /**
     * @inheritDoc
     */
    public function broker()
    {
        return Password::broker('landlords');
    }
}
