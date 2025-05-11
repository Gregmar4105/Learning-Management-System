<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-show',
            'role-create',
            'role-edit',
            'role-delete',
            'assignment-show',
            'assignment-create',
            'assignment-upload',
            'assignment-edit',
            'assignment-delete',
            'user-create',
            'user-edit',
            'user-delete',
            'administrator',
            'Faculty',
            'Student',
        ];

        foreach ($permissions as $key => $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
