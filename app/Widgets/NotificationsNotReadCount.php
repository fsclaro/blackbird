<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Auth;

class NotificationsNotReadCount extends AbstractWidget
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
            'count' => Auth::user()->notifications()->where('is_read', false)->count(),
        ];

        return view('widgets.notifications_not_read_count', [
            'config' => $this->config,
        ]);
    }
}
