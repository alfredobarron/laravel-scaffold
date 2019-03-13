<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EventsTableSeeder extends Seeder
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
            'name' => 'event',
            'display_name' => 'Events',
            'icon' => 'icon-events',
            'active' => true
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-events',
                'display_name' => 'Read Calendar',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-events',
                'display_name' => 'Create Calendar',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-events',
                'display_name' => 'Update Calendar',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-events',
                'display_name' => 'Delete Calendar',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions
        $master = Role::findByName('master');
        $master->givePermissionTo('read-events', 'create-events', 'update-events', 'delete-events');

        $superadmin = Role::findByName('superadmin');
        $superadmin->givePermissionTo('read-events', 'create-events', 'update-events', 'delete-events');

        $admin = Role::findByName('admin');
        $admin->givePermissionTo('read-events', 'create-events', 'update-events', 'delete-events');

        $vendedor = Role::findByName('vendedor');
        $vendedor->givePermissionTo('read-events', 'create-events', 'update-events', 'delete-events');

        $comediante = Role::findByName('comediante');
        $comediante->givePermissionTo('read-events');

        $viewer = Role::findByName('viewer');
        $viewer->givePermissionTo('read-events');
    }
}
