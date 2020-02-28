<?php

use App\Role;
use App\User;
use App\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $execute = true;

        if (User::count() > 0) {
            $this->command->warn('Confirma executar as seeds do sistema? Os registros atuais do banco de dados serão apagados.');
            $question = $this->command->ask('Responda com "S" para sim ou outra tecla qualquer para cancelar');
            if ($question != 'S' && $question != 's') {
                $execute = false;
            } else {
                $this->TruncTables();
            }
        }

        if ($execute) {
            $this->call(SettingTableSeeder::class);
            $this->call(UsersTableSeeder::class);
            $this->call(PermissionsTableSeeder::class);
            $this->call(RolesTableSeeder::class);
            $this->call(PermissionRoleTableSeeder::class);
            $this->call(RoleUserTableSeeder::class);
        } else {
            $this->command->line('Operação cancelada.');
            exit(0);
        }
    }

    public function TruncTables()
    {
        DB::statement('SET foreign_key_checks=0');

        $this->command->info('- Excluindo os registros da tabela users...');
        User::truncate();

        $this->command->info('- Excluindo os registros da tabela de permissions...');
        Permission::truncate();

        $this->command->info('- Excluindo os registros da tabela roles...');
        Role::truncate();

        $this->command->info('- Excluindo os registros da tabela permission_role...');
        DB::table('permission_role')->truncate();

        $this->command->info('- Excluindo os registros da tabela role_user...');
        DB::table('role_user')->truncate();

        $this->command->info('- Excluindo os registros da tabela media...');
        DB::table('media')->truncate();

        $this->command->info('- Excluindo os registros da tabela settings...');
        DB::table('settings')->truncate();

        $this->command->info('- Excluindo os registros da tabela telescope...');
        DB::table('telescope_entries')->truncate();
        DB::table('telescope_entries_tags')->truncate();
        DB::table('telescope_monitoring')->truncate();

        DB::statement('SET foreign_key_checks=1');
    }
}
