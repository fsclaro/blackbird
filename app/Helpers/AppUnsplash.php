<?php

namespace App\Helpers;

class AppUnsplash
{
    public static function getPhoto($featured = true, $username = null, $query = 'travel,business,abstract,wallpapers', $width = 720, $height = null)
    {
        if (env('UNSPLASH')) {
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
        } else {
            return;
        }
    }
}
