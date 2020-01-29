<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Associando as permissões aos papéis...');

        $permissions = Permission::all();

        // atribui as permissões para o papel super_admin
        $this->command->info('- Associando as permissões ao papel SuperAdmin.');

        $permissionSuperAdmin = $permissions->filter(function ($permission) {
            return $permission->slug == 'super_admin';
        });

        Role::findOrFail(1)
            ->permissions()
            ->sync($permissionSuperAdmin->pluck('id'));

        // atribui as permissões para o papel admin
        $this->command->info('- Associando as permissões ao papel Admin.');

        $permissionAdmin = $permissions->filter(function ($permission) {
            return $permission->slug != 'super_admin';
        });

        Role::findOrFail(2)
            ->permissions()
            ->sync($permissionAdmin->pluck('id'));

        // atribui as permissões para o papel user
        $this->command->info('- Associando as permissões ao papel User.');
        $permissionUser = $permissions->filter(function ($permission) {
            return $permission->slug == 'user_profile' ||
                   $permission->slug == 'notification_access' ||
                   $permission->slug == 'notification_show' ||
                   $permission->slug == 'notification_delete' ||
                   $permission->slug == 'log_access';
        });
        Role::findOrFail(3)
            ->permissions()
            ->sync($permissionUser->pluck('id'));
    }
}
