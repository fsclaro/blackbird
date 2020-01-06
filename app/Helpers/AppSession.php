<?php

namespace App\Helpers;

use Session;
use App\Setting;


class AppSession
{
    public static function getSession()
    {
        $settings = Setting::all();

        foreach ($settings as $setting) {
            Session::put($setting->name, $setting->content);
        }
    }
}
