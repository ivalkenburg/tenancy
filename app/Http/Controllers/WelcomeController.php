<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class WelcomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function __invoke()
    {
        return view('welcome');
    }
}
