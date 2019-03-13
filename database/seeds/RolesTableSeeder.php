<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Module
        $moduleId = DB::table('modules')->insertGetId([
            'name' => 'roles',
            'display_name' => 'Roles',
            'icon' => 'icon-key'
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-roles',
                'display_name' => 'Read Roles',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-roles',
                'display_name' => 'Create Roles',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-roles',
                'display_name' => 'Update Roles',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-roles',
                'display_name' => 'Delete Roles',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Create default roles
        $master = Role::create([
            'name' => 'master',
            'display_name' => 'Master'
        ]);
        $superadmin = Role::create([
            'name' => 'superadmin',
            'display_name' => 'SuperAdmin'
        ]);
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin'
        ]);
        $vendedor = Role::create([
            'name' => 'vendedor',
            'display_name' => 'Vendedor'
        ]);
        $comediante = Role::create([
            'name' => 'comediante',
            'display_name' => 'Comediante'
        ]);
        $viewer = Role::create([
            'name' => 'viewer',
            'display_name' => 'Viewer'
        ]);

        // Assign permissions
        $master->givePermissionTo('read-roles', 'create-roles', 'update-roles', 'delete-roles');
    }
}
