<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionGroups = [
            'news' => ['view', 'create', 'edit', 'delete'],
            'events' => ['view', 'create', 'edit', 'delete'],
            'users' => ['view', 'create', 'edit', 'delete'],
            'giftcodes' => ['view', 'create', 'edit', 'delete'],
            'transactions' => ['view', 'create', 'edit'],
            'dashboard' => ['access manager', 'access admin'],
        ];

        $permissions = [];
        foreach ($permissionGroups as $module => $actions) {
            foreach ($actions as $action) {
                $permissions[] = "{$action} {$module}";
            }
        }

        $permissions[] = 'view transactions user';
        $permissions[] = 'update profile';
        

        $this->createPermissions($permissions);

        $rolePermissions = [
            'admin' => $permissions, 
            
            'manager' => [
                'view news', 'create news', 'edit news',
                'view events', 'create events', 'edit events',
                'view users', 'edit users',
                'view giftcodes', 'create giftcodes', 'edit giftcodes',
                'view transactions', 'edit transactions', 'create transactions',
                'view transactions user',
                'access manager dashboard',
                'update profile',
            ],
            
            'user' => [
                'create transactions',
                'view transactions user',
                'update profile',
            ],
        ];

        $this->createRolesWithPermissions($rolePermissions);
    }

    private function createPermissions(array $permissions): void
    {
        $existingPermissions = Permission::pluck('name')->toArray();
        $newPermissions = array_diff($permissions, $existingPermissions);

        $permissionData = [];
        foreach ($newPermissions as $permission) {
            $permissionData[] = [
                'name' => $permission,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($permissionData)) {
            Permission::insert($permissionData);
        }
    }

    private function createRolesWithPermissions(array $rolePermissions): void
    {
        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissions);
        }
    }
}