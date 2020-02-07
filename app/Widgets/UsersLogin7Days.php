<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Charts\UsersLogin7DaysChart;
use Carbon\Carbon;
use App\User;

class UsersLogin7Days extends AbstractWidget
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
        $last7Days = Carbon::now()->subDays(7);

        $days = [];
        $count = [];

        $countDown = 7;
        for ($i=0; $i<=7; $i++)
        {
            $date = Carbon::now()->subDays($countDown);
            $days[$i] = $date->day . '/' . $date->month;

            $count[$i] = User::where('last_login', $date->format('Y-m-d'))->count();
            $countDown--;
        }

        dd($days, $count, $date->format('Y-m-d'));

        $usersChart = new UsersLogin7DaysChart;
        $usersChart->labels(['Jan', 'Feb', 'Mar']);
        $usersChart->dataset('Users by trimester', 'line', [10, 25, 13]);

        return view('widgets.users_login_7days', [
            'usersChart' => $usersChart,
        ]);
    }
}
