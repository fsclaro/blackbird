<?php

namespace App\Widgets;

use App\Setting;
use Arrilot\Widgets\AbstractWidget;

class SettingsCount extends AbstractWidget
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
            'count' => Setting::count(),
        ];

        return view('widgets.settings_count', [
            'config' => $this->config,
        ]);
    }
}
