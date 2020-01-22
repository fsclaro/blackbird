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
        User::insert([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@blackbird.com',
            'password' => Hash::make('superman'),
            'active' => true,
            'skin' => null,
            'is_superadmin' => true,
            'created_at' => now(),
        ]);

        User::insert([
            'name' => 'Admin',
            'email' => 'admin@blackbird.com',
            'password' => Hash::make('12345678'),
            'active' => true,
            'skin' => null,
            'is_superadmin' => false,
            'created_at' => now(),
        ]);

        User::insert([
            'name' => 'User',
            'email' => 'user@blackbird.com',
            'password' => Hash::make('12345678'),
            'active' => true,
            'skin' => null,
            'is_superadmin' => false,
            'created_at' => now(),
        ]);
    }
}
