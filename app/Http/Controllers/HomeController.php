<?php

namespace App\Http\Controllers;

use App\Helpers\Tenancy\Models\Tenant;
use App\Jobs\DelayedJob;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['cache', 'job']);
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function mail(Request $request)
    {
        Mail::to($request->user())->send(new TestMail);

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function job()
    {
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
}
