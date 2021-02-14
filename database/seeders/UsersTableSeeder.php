<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UsersTableSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create files']);
        Permission::create(['name' => 'read files']);
        Permission::create(['name' => 'edit files']);
        Permission::create(['name' => 'delete files']);
        Permission::create(['name' => 'publish files']);
        Permission::create(['name' => 'unpublish files']);
        Permission::create(['name' => 'create availability']);
        Permission::create(['name' => 'read availability']);
        Permission::create(['name' => 'edit availability']);
        Permission::create(['name' => 'delete availability']);

        // create roles and assign existing permissions
        $lawyerRole = Role::create(['name' => 'lawyer']);
        $lawyerRole->givePermissionTo(['create availability', 'read availability', 'edit availability', 'delete availability']);

        $traineeRole = Role::create(['name' => 'trainee']);
        $traineeRole->givePermissionTo('read files');

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Lawyer User',
            'email' => 'lawyer@example.com',
        ]);
        $user->assignRole($lawyerRole);

        $user = \App\Models\User::factory()->create([
            'name' => 'Trainee User',
            'email' => 'trainee@example.com',
        ]);
        $user->assignRole($traineeRole);

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $user->assignRole($admin);
    }
}