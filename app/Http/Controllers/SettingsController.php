<?php

namespace App\Http\Controllers;

use App\Packages\LaravelSettings\Facades\Settings;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingsController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function current()
    {
        return view('settings', ['settings' => Settings::get()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function set(Request $request)
    {
        $request->validate(['foobar' => ['required', 'string']]);

        Settings::set('foobar', $request->foobar);

        return redirect()->back();
    }
}
