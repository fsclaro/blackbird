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

        /*
         * =======================================
         * Usuário superadmin
         * =======================================
         */
        $this->command->info(' Criando o usuário SuperAdmin.');
        $user = User::insert([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@bb7.test',
            'password' => Hash::make('superman'),
            'active' => true,
            'skin' => null,
            'is_superadmin' => true,
            'created_at' => now(),
        ]);
        $user = User::find(1);
        $user->addMedia(public_path('img/avatares/Others/superman.png'))
            ->preservingOriginal()
            ->toMediaCollection('avatars');

        /*
         * =======================================
         * Usuário admin
         * =======================================
         */
        $this->command->info(' Criando o usuário Admin.');
        $user = User::insert([
            'name' => 'Admin',
            'email' => 'admin@bb7.test',
            'password' => Hash::make('admin'),
            'active' => true,
            'skin' => null,
            'is_superadmin' => false,
            'created_at' => now(),
        ]);
        $user = User::find(2);
        $user->addMedia(public_path('img/avatares/Others/admin.png'))
            ->preservingOriginal()
            ->toMediaCollection('avatars');

        /*
         * =======================================
         * Usuário user
         * =======================================
         */
        $this->command->info(' Criando o usuário User.');
        $user = User::insert([
            'name' => 'User',
            'email' => 'user@bb7.test',
            'password' => Hash::make('user'),
            'active' => true,
            'skin' => null,
            'is_superadmin' => false,
            'created_at' => now(),
        ]);
        $user = User::find(3);
        $user->addMedia(public_path('img/avatares/Male/avatar_001.png'))
            ->preservingOriginal()
            ->toMediaCollection('avatars');
    }
}
