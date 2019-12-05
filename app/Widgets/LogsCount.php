<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Logs;

class LogsCount extends AbstractWidget
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
            'count' => Logs::count(),
        ];

        return view('widgets.logs_count', [
            'config' => $this->config,
        ]);
    }
}
