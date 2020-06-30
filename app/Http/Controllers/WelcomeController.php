<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function __invoke()
    {
        return view('welcome', [
            'cached' => Cache::get('cached_value')
        ]);
    }
}
