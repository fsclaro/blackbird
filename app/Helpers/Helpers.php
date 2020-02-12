<?php

namespace App\Helpers;

use Session;
use App\Setting;

class Helpers
{
    /**
     * =================================================================
     * get sessions values
     * =================================================================.
     *
     * @return void
     */
    public static function getSession()
    {
        $settings = Setting::all();

        foreach ($settings as $setting) {
            Session::put($setting->name, $setting->content);
        }
    }

    /**
     * =================================================================
     * return a random picture of unplash platform
     * =================================================================.
     *
     * @param bool $featured
     * @param string $username
     * @param string $query
     * @param int $width
     * @param int $height
     *
     * @return void
     */
    public static function getUnsplashPicture(
        $featured = true,
        $username = null,
        $query = 'abstract',
        $width = 720,
        $height = null
    ) {
        if (env('UNSPLASH') || Session::get('use_unsplash')) {
            try {
                \Crew\Unsplash\HttpClient::init([
                    'applicationId' => env('UNSPLASH_ACCESS_KEY'),
                    'secret' => env('UNSPLASH_SECRET_KEY'),
                    'callbackUrl' => env('UNSPLASH_CALLBACK_URL'),
                    'utmSource' => env('UNSPLASH_UTM_SOURCE'),
                ]);

                $filter = [
                    'featured' => $featured,
                    'username' => $username,
                    'query' => $query,
                    'w' => $width,
                    'h' => $height,
                ];

                $photo = \Crew\Unsplash\Photo::random($filter);

                $url = $photo->urls['thumb'].'&dpi=1';

                return $url;
            } catch (\Throwable $th) {
                return;
            }
        } else {
            return;
        }
    }

    /**
     * =================================================================
     * return a external ip.
     * =================================================================.
     *
     * @return void
     */
    public static function getExternalIP()
    {
        $external_ip = null;

        if (Session::get('get_external_ip')) {
            try {
                $external_ip = file_get_contents(Session::get('url_external_ip'));
            } catch (\Throwable $th) {
                return;
            }
        }

        return $external_ip;
    }

    /**
     * =================================================================
     * return a local ip.
     * =================================================================.
     *
     * @return void
     */
    public static function getIP()
    {
        //se possível, obtém o endereço ip da máquina do cliente
        if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //verifica se o ip está passando pelo proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }
}
