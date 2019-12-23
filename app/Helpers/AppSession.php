<?php
namespace App\Helpers;

use App\Setting;
use Session;

Class AppSession {
    public static function getSession() {
        $settings = Setting::all();

        foreach ($settings as $setting) {
            Session::put($setting->name, $setting->content);
        }

    }

}
