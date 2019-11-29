<?php

namespace App\Widgets;

use App\User;
use Arrilot\Widgets\AbstractWidget;

class UsersInactivesCount extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $this->config = [
            'count' => User::where('active', 0)->count(),
        ];

        return view('widgets.users_inactives_count', [
            'config' => $this->config,
        ]);
    }
}
