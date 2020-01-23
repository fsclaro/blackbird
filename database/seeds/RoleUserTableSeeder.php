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
        $this->command->info('Associando os papéis aos usuários do sistema...');

        $this->command->info('- Associando o papel ao usuãrio SuperAdmin.');
        User::findOrFail(1)->roles()->sync(1);

        $this->command->info('- Associando o papel ao usuãrio Admin.');
        User::findOrFail(2)->roles()->sync(2);

        $this->command->info('- Associando o papel ao usuãrio User.');
        User::findOrFail(3)->roles()->sync(3);
    }
}
