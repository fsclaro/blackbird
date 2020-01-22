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
        // atribui todas as permissões para o papel admin
        $admin_permissions = Permission::all();
        Role::findOrFail(2)
            ->permissions()
            ->sync($admin_permissions->pluck('id'));

        // seleciona as permissões para serem atribuídas para o papel user
        $user_permissions = $admin_permissions
            ->filter(function ($permission) {
                return $permission->slug == 'user_profile';
            }
        );

        // atribui as pemissões selecionadas para o papel user
        Role::findOrFail(3)
            ->permissions()
            ->sync($user_permissions->pluck('id'));
    }
}
