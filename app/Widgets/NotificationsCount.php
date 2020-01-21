<?php

namespace App\Widgets;

use Auth;
use Arrilot\Widgets\AbstractWidget;

class NotificationsCount extends AbstractWidget
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
            'count' => Auth::user()->notifications()->count(),
        ];

        return view('widgets.notifications_count', [
            'config' => $this->config,
        ]);
    }
}
