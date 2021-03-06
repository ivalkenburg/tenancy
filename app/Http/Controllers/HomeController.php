<?php

namespace App\Http\Controllers;

use App\Notifications\TestNotification;
use App\Packages\LaravelTotp\Http\Middleware\EnsureTotpEnabled;
use App\Support\Multitenancy\Models\Tenant;
use App\Jobs\DelayedJob;
use App\Mail\TestMail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use function App\Support\can;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['home', 'cache', 'test']);
        $this->middleware(EnsureTotpEnabled::class)->only('totpRequired');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function home()
    {
        return view('home');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notification()
    {
        abort_unless(can('send.notifications'), Response::HTTP_UNAUTHORIZED);

        auth()->user()->notify(new TestNotification);

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function mail()
    {
        abort_unless(can('send.mails'), Response::HTTP_UNAUTHORIZED);

        $user = auth()->user();
        Mail::to($user)->send(new TestMail($user->name));

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function job()
    {
        abort_unless(can('dispatch.jobs'), Response::HTTP_UNAUTHORIZED);

        DelayedJob::dispatch(rand(5, 15));

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cache()
    {
        Cache::put('cached_value', Tenant::currentId() ?: 'no tenant', 200000);

        return redirect()->back();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function totpRequired()
    {
        return view('totp_required');
    }
}
