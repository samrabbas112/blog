<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions if they do not already exist
        $permissions = [
            'edit posts',
            'delete posts',
            'publish posts',
            'view all posts',
            'create posts',
            'unpublish posts',
            'create tags',
            'delete tags',
            'edit tags',
            'create category',
            'delete category',
            'edit category',
            'create user',
            'delete user',
            'edit user',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Editor role - manages posts, tags, and categories
        $editor = Role::firstOrCreate(['name' => 'Editor']);
        $editor->syncPermissions([
            'edit posts',
            'delete posts',
            'create tags',
            'edit tags',
            'delete tags',
            'create category',
            'edit category',
            'delete category',
        ]);

        // Creator role - can create, publish, and unpublish posts; create tags and categories
        $creator = Role::firstOrCreate(['name' => 'Creator']);
        $creator->syncPermissions([
            'create posts',
            'publish posts',
            'edit posts',
            'delete posts',
            'unpublish posts',
            'create tags',
            'create category',
        ]);

        // Super Admin role - full access to everything
        $admin = Role::firstOrCreate(['name' => 'Super Admin']);
        $admin->syncPermissions(Permission::all()); // Super Admin has all permissions

        // Assign Super Admin role to the first user
        $user = User::where('id', 1)->first();
        if ($user) {
            $user->assignRole('Super Admin');
        }

      

    }
}
