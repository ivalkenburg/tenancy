<?php

namespace App\Http\Controllers\Landlord;

use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function __invoke()
    {
        return view('landlord.home');
    }
}
