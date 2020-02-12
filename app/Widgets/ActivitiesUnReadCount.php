<?php

namespace App\Widgets;

use App\Activity;
use Arrilot\Widgets\AbstractWidget;

class ActivitiesUnReadCount extends AbstractWidget
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
            'count' => Activity::where('is_read', false)->count(),
         ];

        return view('widgets.activities_unread_count', [
            'config' => $this->config,
        ]);
    }
}
