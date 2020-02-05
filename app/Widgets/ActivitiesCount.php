<?php

namespace App\Widgets;

use App\Activity;
use Arrilot\Widgets\AbstractWidget;

class ActivitiesCount extends AbstractWidget
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
            'count' => Activity::count(),
        ];

        return view('widgets.activities_count', [
            'config' => $this->config,
        ]);
    }
}
