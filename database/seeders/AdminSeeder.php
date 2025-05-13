<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the Administrator role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'Administrator']);

        // Get all the permissions from the PermissionSeeder
        $permissions = Permission::pluck('name')->toArray();

        // Assign all permissions to the Administrator role
        $adminRole->givePermissionTo($permissions);

        // Create the admin user if it doesn't exist
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@philsca.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('Admin@philsca'), // Change 'password' to a secure password
            ]
        );

        // Assign the Administrator role to the admin user
        $adminUser->assignRole('Administrator');
    }
}
