<?php

namespace App\Http\Controllers\Landlord;

use App\Events\TestEvent;
use App\Mail\Landlord\TestMail;
use App\Notifications\Landlord\TestNotification;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function home()
    {
        return view('landlord.home');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notification()
    {
        auth()->user()->notify(new TestNotification(Str::random()));

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function mail()
    {
        Mail::to(auth()->user())->send(new TestMail(auth()->user()->name));

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function event()
    {
        event(new TestEvent);

        return redirect()->back();
    }
}
