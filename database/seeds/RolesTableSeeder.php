<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Criando os papéis do sistema...');

        $this->command->info(' Criando o papel de SuperAdmin.');
        Role::insert(['title' => 'SuperAdmin', 'created_at' => now()]);

        $this->command->info(' Criando o papel Admin.');
        Role::insert(['title' => 'Admin', 'created_at' => now()]);

        $this->command->info(' Criando o papel User.');
        Role::insert(['title' => 'User', 'created_at' => now()]);
    }
}
