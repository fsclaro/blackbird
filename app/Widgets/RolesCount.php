<?php

namespace App\Widgets;

use App\Role;
use Arrilot\Widgets\AbstractWidget;

class RolesCount extends AbstractWidget
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
            'count' => Role::count(),
        ];

        return view('widgets.roles_count', [
            'config' => $this->config,
        ]);
    }
}
