<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create roles and assign created permissions
        Role::create(['name' => 'USUARIO'])->givePermissionTo('view user');
        Role::create(['name' => 'ADMINISTRADOR'])->givePermissionTo(Permission::all());
    }
}
