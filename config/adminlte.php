<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title' => 'Blackbird',
    'title_prefix' => '{',
    'title_postfix' => '}',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-logo
    |
    */

    'logo' => '<b>Black</b>bird',
    'logo_img' => 'img/logo-sm.png',
    'logo_img_class' => 'brand-image-xl',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Blackbird',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Extra Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_header' => 'container-fluid',
    'classes_content' => 'container-fluid',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand-md',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-sidebar
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#66-control-sidebar-right-sidebar
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-th-large',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => false,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-urls
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-laravel-mix
    |
    */

    'enabled_laravel_mix' => false,

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-menu
    |
    */

    'menu' => [
        // [
        //     'text' => 'pesquisar',
        //     'search' => true,
        //     'topnav' => true,
        // ],
        [
            'text'  => 'Dashboard',
            'icon'  => 'fas fa-fw fa-tachometer-alt',
            'route' => 'home',
        ],
        [
            'header' => 'ADMINISTRAÇÃO DO SITE',
            'can' => 'site_management',
        ],

        [
            'text' => 'Gestão de Acesso',
            'icon' => 'fas fa-fw fa-compass',
            'icon_color' => 'yellow',
            'can' => 'access_management',
            'submenu' => [
                [
                    'text' => 'Usuários',
                    'icon'    => 'fas fa-fw fa-users',
                    'can'   => 'user_access',
                    'route' => 'admin.users.index',
                ],
                [
                    'text'    => 'Papéis',
                    'icon'    => 'fas fa-fw fa-user-tag',
                    'can'     => 'role_access',
                    'route' => 'admin.roles.index',
                ],
                [
                    'text'    => 'Permissões',
                    'icon'    => 'fas fa-fw fa-key',
                    'can'   => 'permission_access',
                    'route' => 'admin.permissions.index',
                ],
            ],
        ],
        [
            'text'    => 'Parametrização',
            'icon'    => 'fas fa-fw fa-cubes',
            'icon_color' => 'yellow',
            'can'     => 'setting_access',
            'submenu' => [
                [
                    'text'  => 'Parâmetros',
                    'icon'  => 'fas fa-fw fa-database',
                    'can'   => 'setting_access',
                    'route' => 'admin.settings.index',
                ],
                [
                    'text'  => 'Valores',
                    'icon'  => 'fas fa-fw fa-bullhorn',
                    'can'   => 'setting_content',
                    'route' => 'admin.settings.content',
                ],
            ],
        ],
        [
            'text'    => 'Suporte',
            'icon'    => 'fas fa-fw fa-user-secret',
            'icon_color' => 'yellow',
            'can'     => 'support_access',
            'submenu' => [
                [
                    'text' => 'Log de Atividades',
                    'icon' => 'fas fa-fw fa-flag',
                    'can' => 'log_access',
                    'route' => 'admin.logs.index',
                ],
                [
                    'text'   => 'Log Viewer',
                    'icon'   => 'fas fa-fw fa-eye',
                    'can'    => 'log_viewer_access',
                    'route'  => 'log-viewer::dashboard',
                    'target' => '_blank',
                ],
                [
                    'text'   => 'Route Viewer',
                    'icon'   => 'fas fa-fw fa-eye',
                    'can'    => 'route_viewer_access',
                    'route'  => 'route-viewer::index',
                    'target' => '_blank',
                ],
                [
                    'text'   => 'PHPInfo',
                    'icon'   => 'fas fa-fw fa-info',
                    'can'    => 'phpinfo_viewer',
                    'route'  => 'api.phpinfo',
                    'target' => '_blank',
                ],
                [
                    'text'   => 'Telescope',
                    'icon'   => 'fas fa-fw fa-bullhorn',
                    'can'    => 'telescope_viewer',
                    'route'  => 'telescope',
                    'target' => '_blank',
                ],

            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-plugins
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        [
            'name' => 'Select2',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/i18n/pt-BR.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
            ],
        ],
        [
            'name' => 'Chartjs',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/chart.js/Chart.bundle.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/chart.js/Chart.min.css',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.all.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
                ],
            ],
        ],
        [
            'name' => 'Pace',
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/pace-progress/themes/blue/pace-theme-corner-indicator.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/pace-progress/pace.min.js',
                ],
            ],
        ],
        [
            'name' => 'Summernote',
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/summernote/summernote-bs4.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/summernote/summernote-bs4.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/summernote/lang/summernote-pt-BR.js',
                ],
            ],
        ],
        [
            'name' => 'iCheck-Bootstrap',
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/icheck-bootstrap/icheck-bootstrap.min.css',
                ],
            ],
        ],
        [
            'name' => 'FastClick',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/fastclick/fastclick.js',
                ],
            ],
        ],
        [
            'name' => 'Popper',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/popper/popper.min.js',
                ],
            ],
        ],
        [
            'name' => 'overlayScrollbars',
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/overlayScrollbars/css/OverlayScrollbars.min.css',
                ],
            ],
        ],
    ],
];
