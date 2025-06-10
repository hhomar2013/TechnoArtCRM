<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class allData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        Permission::create(['name' => 'AdminDashboard']);
        Permission::create(['name' => 'settings']);
        Permission::create(['name' => 'usersManagement']);
        Permission::create(['name' => 'addUsers']);
        Permission::create(['name' => 'updateUsers']);
        Permission::create(['name' => 'deleteUsers']);
        Permission::create(['name' => 'rolesManagement']);
        Permission::create(['name' => 'addRoles']);
        Permission::create(['name' => 'updateRoles']);
        Permission::create(['name' => 'deleteRoles']);
        Permission::create(['name' => 'permissionsManagement']);
        Permission::create(['name' => 'addPermissions']);
        Permission::create(['name' => 'updatePermissions']);
        Permission::create(['name' => 'deletePermissions']);


        $role = Role::findByName('SuperAdmin');
        $role->givePermissionTo([
            'AdminDashboard',
            'settings',
            'addUsers',
            'deleteUsers',
            'updateUsers',
            'usersManagement',
            'addRoles',
            'updateRoles',
            'deleteRoles',
            'rolesManagement',
            'addPermissions',
            'updatePermissions',
            'deletePermissions',
            'permissionsManagement',
        ]);

        $user= User::query()->create([
            'name' => 'superadmin',
            'email' => 'omar@app.com',
            'password' => bcrypt('123456'),
        ]);
        $user->syncRoles($role);
    }
}
