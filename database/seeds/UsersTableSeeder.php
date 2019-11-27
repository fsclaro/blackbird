<?php

use Illuminate\Database\Seeder;
use App\User;

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
            'name' => 'Admin',
            'email' => 'admin@blackbird.test',
            'password' => Hash::make('12345678')
        ]);

        User::insert([
            'name' => 'User',
            'email' => 'user@blackbird.test',
            'password' => Hash::make('12345678')
        ]);
    }
}
