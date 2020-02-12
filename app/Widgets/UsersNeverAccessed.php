<?php

namespace App\Widgets;

use App\User;
use Arrilot\Widgets\AbstractWidget;

class UsersNeverAccessed extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config;

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $users = User::whereNull('last_login')->take(8)->get();

        $this->config = $users;

        return view('widgets.users_never_accessed', [
            'users' => $this->config,
        ]);
    }
}
