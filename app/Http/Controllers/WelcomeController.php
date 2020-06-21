<?php

namespace App\Http\Controllers;

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
