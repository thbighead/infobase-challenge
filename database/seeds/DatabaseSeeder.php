<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        DB::table('users')->insert([
            'name' => 'Thales Nathan',
            'cpf' => '10817831762',
            'email' => 'thcmatias@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => $now,
            'created_at' => $now,
        ]);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        DB::table('model_has_roles')->insert([
            'role_id' => 2, // ADMINISTRADOR
            'model_type' => 'App\User',
            'model_id' => 1
        ]);
        $this->call(UsersTableSeeder::class);
    }
}
