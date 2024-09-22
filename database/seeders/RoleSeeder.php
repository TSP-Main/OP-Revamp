<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create roles
        $superAdmin = Role::create(['name' => 'super_admin']);
        $dispensary = Role::create(['name' => 'dispensary']);
        $doctor = Role::create(['name' => 'doctor']);
        $user = Role::create(['name' => 'user']);

        //create permissions
//        Permission::create(['name' => 'manage users']);
//        Permission::create(['name' => 'view reports']);
//        Permission::create(['name' => 'manage dispensary']);
//        Permission::create(['name' => 'manage doctor tasks']);
//
//        // Assign Permissions to Roles
//        $superAdmin->givePermissionTo(Permission::all());
//        $dispensary->givePermissionTo('manage dispensary');
//        $doctor->givePermissionTo('manage doctor tasks');
//        $user->givePermissionTo('view reports');
    }
}
