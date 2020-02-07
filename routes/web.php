<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function() {
//     return view('welcome');
// });
Route::redirect('/', '/login');
Route::redirect('/home', '/admin');

Auth::routes(['register' => false]);

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::group(
    [
        'prefix'     => 'admin',
        'as'         => 'admin.',
        'namespace'  => 'Admin',
        'middleware' => ['auth'],
    ],
    function () {
        /* Rota para a tela do dashboard */
        Route::get('/', 'HomeController@index')->name('home');

        /* Rotas da tabela de permissões */
        Route::resource('permissions', 'PermissionController');

        /* Rotas da tabela de papéis */
        Route::resource('roles', 'RoleController');
        Route::post('roles/clone', 'RoleController@clone')->name('roles.clone');
        Route::post('roles/deleteroles', 'RoleController@deleteRoles')->name('roles.deleteroles');

        /* Rotas da tabela de usuários */
        Route::resource('users', 'UserController');
        Route::get('users/delete/avatar/{user}', 'UserController@deleteAvatar')->name('users.delete.avatar');
        Route::get('users/profile/{user}', 'UserController@changeProfile')->name('users.profile');
        Route::put('users/profile/update/{user}', 'UserController@updateProfile')->name('users.update.profile');
        Route::post('users/active', 'UserController@activeUsers')->name('users.active');
        Route::post('users/desactive', 'UserController@desactiveUsers')->name('users.desactive');
        Route::post('users/deleteusers', 'UserController@deleteUsers')->name('users.deleteusers');
        Route::get('users/login7days', 'UserController@getLogin7Days')->name('users.login7days');
        Route::get('users/login30days', 'UserController@getLogin30Days')->name('users.login30days');

        /* Rotas da tabela de parâmetros */
        Route::get('settings/content', 'SettingController@getContent')->name('settings.content');
        Route::post('settings/content/save', 'SettingController@saveContent')->name('settings.savecontent');
        Route::resource('settings', 'SettingController');

        /* Rotas da tabela de atividades */
        Route::get('activities/user', 'ActivityController@getAllUserActivities')->name('activities.user');
        Route::resource('activities', 'ActivityController')->except(['create', 'edit', 'update', 'store']);
        Route::post('activities/read', 'ActivityController@readActivities')->name('activities.read');
        Route::post('activities/unread', 'ActivityController@unreadActivities')->name('activities.unread');
        Route::post('activities/deleteactivities', 'ActivityController@deleteActivities')
            ->name('activities.deleteactivities');
    }
);

Route::group(
    [
        'prefix'     => 'api',
        'as'         => 'api.',
        'namespace'  => 'Api',
        'middleware' => ['auth'],
    ],
    function () {
        /* Rota para rotinas diversas */
        Route::get('phpinfo', 'HelpersController@showPhpInfo')->name('phpinfo');
    }
);
