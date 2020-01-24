<?php

namespace App\Menufilter;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Auth;

class SuperAdminFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {

        if (!isset($item['can']) || Auth::user()->is_superadmin) {
            return $item;
        } else {
            if (\Gate::allows($item['can'])) {
                return $item;
            }
        }

        return false;
    }
}
