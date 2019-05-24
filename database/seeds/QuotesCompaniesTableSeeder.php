<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class QuotesCompaniesTableSeeder extends Seeder
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
            'name' => 'quotescompanies',
            'display_name' => 'Quotes Companies',
            'icon' => 'icon-quotescompanies',
            'active' => true
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-quotescompanies',
                'display_name' => 'Read Quotes Companies',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-quotescompanies',
                'display_name' => 'Create Quotes Companies',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-quotescompanies',
                'display_name' => 'Update Quotes Companies',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-quotescompanies',
                'display_name' => 'Delete Quotes Companies',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions
        $master = Role::findByName('master');
        $master->givePermissionTo('read-quotescompanies', 'create-quotescompanies', 'update-quotescompanies', 'delete-quotescompanies');

        $superadmin = Role::findByName('superadmin');
        $superadmin->givePermissionTo('read-quotescompanies', 'create-quotescompanies', 'update-quotescompanies', 'delete-quotescompanies');

        $admin = Role::findByName('admin');
        $admin->givePermissionTo('read-quotescompanies', 'create-quotescompanies', 'update-quotescompanies', 'delete-quotescompanies');

        $vendedor = Role::findByName('vendedor');
        $vendedor->givePermissionTo('read-quotescompanies', 'create-quotescompanies', 'update-quotescompanies', 'delete-quotescompanies');

    }
}
