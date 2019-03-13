<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProfileTableSeeder extends Seeder
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
            'name' => 'profile',
            'display_name' => 'Profile',
            'icon' => 'icon-user',
            'active' => false
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-profile',
                'display_name' => 'Read Profile',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-profile',
                'display_name' => 'Update Profile',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'read-profile-password',
                'display_name' => 'Read Password',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-profile-password',
                'display_name' => 'Update Password',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions
        $master = Role::findByName('master');
        $master->givePermissionTo('read-profile', 'update-profile', 'read-profile-password', 'update-profile-password');

        $superadmin = Role::findByName('superadmin');
        $superadmin->givePermissionTo('read-profile', 'update-profile', 'read-profile-password', 'update-profile-password');

        $admin = Role::findByName('admin');
        $admin->givePermissionTo('read-profile', 'update-profile', 'read-profile-password', 'update-profile-password');

        $vendedor = Role::findByName('vendedor');
        $vendedor->givePermissionTo('read-profile', 'update-profile', 'read-profile-password', 'update-profile-password');

        $comediante = Role::findByName('comediante');
        $comediante->givePermissionTo('read-profile', 'update-profile', 'read-profile-password', 'update-profile-password');

        $viewer = Role::findByName('viewer');
        $viewer->givePermissionTo('read-profile', 'update-profile', 'read-profile-password', 'update-profile-password');

    }
}
