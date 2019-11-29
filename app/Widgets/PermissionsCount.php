<?php

namespace App\Widgets;

use App\Permission;
use Arrilot\Widgets\AbstractWidget;

class PermissionsCount extends AbstractWidget
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
            'count' => Permission::count(),
        ];

        return view('widgets.permissions_count', [
            'config' => $this->config,
        ]);
    }
}
