<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Charts\UsersLogin30DaysChart;
use Carbon\Carbon;
use App\User;

class UsersLogin30Days extends AbstractWidget
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
        $days = [];
        $count = [];

        $countDown = 30;
        for ($i=0; $i<=30; $i++)
        {
            $date = Carbon::now()->subDays($countDown);
            $days[$i] = $date->format('d/m');

            $count[$i] = User::where('last_login', $date->format('Y-m-d'))->count();
            $countDown--;
        }

        $usersChart30Days = new UsersLogin30DaysChart;
        $usersChart30Days->labels($days);
        $usersChart30Days->dataset('Quantidade de Acessos', 'line', $count);
        $usersChart30Days->height(200);
        $usersChart30Days->title('Acessos nos últimos 30 dias');
        $usersChart30Days->displayLegend(false);

        return view('widgets.users_login_30days', [
            'usersChart30Days' => $usersChart30Days,
        ]);
    }
}
