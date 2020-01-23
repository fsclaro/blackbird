<?php

namespace App\Menufilter;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use App\User;
use Auth;

class SuperAdminFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {

        if (isset($item['permission']) || Auth::user()->is_superadmin) {
            return $item;
        }

        return false;
    }
}
