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
        Role::insert(['title' => 'Admin', 'created_at' => now()]);
        Role::insert(['title' => 'User', 'created_at' => now()]);
    }
}
