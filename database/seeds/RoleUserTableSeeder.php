<?php

use App\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::findOrFail(2)->roles()->sync(1);
        User::findOrFail(3)->roles()->sync(2);
    }
}
