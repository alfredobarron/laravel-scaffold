<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class QuotesTableSeeder extends Seeder
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
            'name' => 'quotes',
            'display_name' => 'Quotes',
            'icon' => 'icon-quotes',
            'active' => true
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-quotes',
                'display_name' => 'Read Quotes',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-quotes',
                'display_name' => 'Create Quotes',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-quotes',
                'display_name' => 'Update Quotes',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-quotes',
                'display_name' => 'Delete Quotes',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions
        $master = Role::findByName('master');
        $master->givePermissionTo('read-quotes', 'create-quotes', 'update-quotes', 'delete-quotes');

        $superadmin = Role::findByName('superadmin');
        $superadmin->givePermissionTo('read-quotes', 'create-quotes', 'update-quotes', 'delete-quotes');

        $admin = Role::findByName('admin');
        $admin->givePermissionTo('read-quotes', 'create-quotes', 'update-quotes', 'delete-quotes');

        $vendedor = Role::findByName('vendedor');
        $vendedor->givePermissionTo('read-quotes', 'create-quotes', 'update-quotes', 'delete-quotes');

    }
}
