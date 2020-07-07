<?php

namespace App\Http\Controllers;

use App\Packages\LaravelSettings\Facades\Settings;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use function App\Support\can;

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
    public function update(Request $request)
    {
        abort_unless(can('change.settings'), Response::HTTP_UNAUTHORIZED);

        $request->validate(['foobar' => ['nullable', 'string']]);

        Settings::set('foobar', $request->foobar);

        return redirect()->back();
    }
}
