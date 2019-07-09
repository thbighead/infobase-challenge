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
        factory(User::class, 1000)->create()->each(function (User $user) {
            $user->assignRole('USUARIO');
        });
        factory(User::class, 1000)->create()->each(function (User $user) {
            $user->assignRole('ADMINISTRADOR');
        });
    }
}
