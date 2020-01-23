<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Permission;
use App\Role;

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
            if ($question != "S" && $question != "s") {
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

        DB::statement("SET foreign_key_checks=0");

        $this->command->info('- Excluindo os registros da tabela users...');
        User::truncate();

        $this->command->info('- Excluindo os registros da table de permissions...');
        Permission::truncate();

        $this->command->info('- Excluindo os registros da tabela roles...');
        Role::truncate();

        DB::statement("SET foreign_key_checks=1");
    }
}
