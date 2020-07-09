<?php

namespace App\Http\Controllers\Landlord;

use App\Notifications\TestNotification;
use Illuminate\Routing\Controller;
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
    public function test()
    {
        auth()->user()->notify(new TestNotification(Str::random()));

        return redirect()->back();
    }
}
