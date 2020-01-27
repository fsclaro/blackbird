<?php

namespace App\Http\Controllers\Admin;

class HomeController
{
    /**
     * ---------------------------------------------------------------
     * call view home
     * ---------------------------------------------------------------
     *
     * @return void
     */
    public function index()
    {
        return view('home');
    }
}
