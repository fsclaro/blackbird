<?php

return [

    /* -----------------------------------------------------------------
     |  Theme
     | -----------------------------------------------------------------
     */

    'theme' => 'bootstrap-4',

    /* -----------------------------------------------------------------
     |  Route settings
     | -----------------------------------------------------------------
     */

    'route'         => [
        'enabled'    => true,

        'attributes' => [
            'prefix'     => 'route-viewer',

            'as'         => 'route-viewer::',

            'namespace'  => 'Arcanedev\\RouteViewer\\Http\\Controllers',

            'middleware' => ['web', 'auth'],
        ],
    ],

    /* -----------------------------------------------------------------
     |  URIs
     | -----------------------------------------------------------------
     */

    'uris'     => [
        'excluded' => [
            '_debugbar',
            '_ignition',
            'route-viewer',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Methods
     | -----------------------------------------------------------------
     */

    'methods'  => [
        'excluded' => [
            'HEAD',
        ],

        'colors' => [
            'GET'    => 'success',
            'HEAD'   => 'default',
            'POST'   => 'primary',
            'PUT'    => 'warning',
            'PATCH'  => 'info',
            'DELETE' => 'danger',
        ],
    ],

];
