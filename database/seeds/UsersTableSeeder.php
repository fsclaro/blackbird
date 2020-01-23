<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Criando os usuários do sistema...');

        $this->command->info('- Criando o usuário SuperAdmin.');
        User::insert([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@blackbird.test',
            'password' => Hash::make('superman'),
            'active' => true,
            'skin' => null,
            'is_superadmin' => true,
            'created_at' => now(),
        ]);

        $this->command->info('- Criando o usuário Admin.');
        User::insert([
            'name' => 'Admin',
            'email' => 'admin@blackbird.test',
            'password' => Hash::make('12345678'),
            'active' => true,
            'skin' => null,
            'is_superadmin' => false,
            'created_at' => now(),
        ]);

        $this->command->info('- Criando o usuário User.');
        User::insert([
            'name' => 'User',
            'email' => 'user@blackbird.test',
            'password' => Hash::make('12345678'),
            'active' => true,
            'skin' => null,
            'is_superadmin' => false,
            'created_at' => now(),
        ]);
    }
}
