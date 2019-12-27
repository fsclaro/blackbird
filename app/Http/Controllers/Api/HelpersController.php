<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class HelpersController extends Controller
{
    public function show_phpinfo()
    {
        return view('api.phpinfo');
    }
}
