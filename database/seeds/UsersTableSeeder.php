<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
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
            'name' => 'users',
            'display_name' => 'Users',
            'icon' => 'icon-people'
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-users',
                'display_name' => 'Read Users',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-users',
                'display_name' => 'Create Users',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-users',
                'display_name' => 'Update Users',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-users',
                'display_name' => 'Delete Users',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions
        $master = Role::findByName('master');
        $master->givePermissionTo('read-users', 'create-users', 'update-users', 'delete-users');

        $master = Role::findByName('superadmin');
        $master->givePermissionTo('read-users', 'create-users', 'update-users', 'delete-users');

        // Create users
        $users = [
            ['name' => 'admin', 'email' => 'admin@modulr.io', 'role' => 'master'],
            ['name' => 'Alan Saldaña', 'email' => 'alansaldana@ascomediantes.mx', 'role' => 'superadmin'],
            ['name' => 'JOSÉ LUIS', 'email' => 'jldelgado@ascomediantes.mx', 'role' => 'superadmin'],
            ['name' => 'Ivonne', 'email' => 'iloredo@ascomediantes.mx', 'role' => 'superadmin'],
            ['name' => 'Gabo', 'email' => 'gdelgado@ascomediantes.mx', 'role' => 'admin'],
            ['name' => 'Marcela', 'email' => 'mgarcia@ascomediantes.mx', 'role' => 'admin'],
            ['name' => 'Manuel', 'email' => 'mvelazquez@ascomediantes.mx', 'role' => 'vendedor'],
            ['name' => 'Jesus', 'email' => 'jsaucedo@ascomediantes.mx', 'role' => 'vendedor'],
            ['name' => 'Cesar', 'email' => 'chernandez@ascomediantes.mx', 'role' => 'vendedor'],
            ['name' => 'Alex', 'email' => 'salasalex55@gmail.com', 'role' => 'comediante'],
            ['name' => 'Ana', 'email' => 'maldonado_anna@hotmail.com', 'role' => 'comediante'],
            ['name' => 'Ivan', 'email' => 'comanche32@hotmail.com', 'role' => 'comediante'],
            ['name' => 'JR Adams', 'email' => 'printcedillo@hotmail.com', 'role' => 'comediante'],
            ['name' => 'Mao', 'email' => 'comediante.mao@gmail.com', 'role' => 'comediante'],
            ['name' => 'Garrapatas', 'email' => 'rickycampa62@gmail.com', 'role' => 'comediante'],
            ['name' => 'Jorge', 'email' => 'jorgegongorashow@hotmail.com', 'role' => 'comediante'],
            ['name' => 'Salomon', 'email' => 'salomon130174@gmail.com', 'role' => 'comediante'],
            ['name' => 'Jhonny', 'email' => 'jhonnyhdzshow@hotmail.com', 'role' => 'comediante'],
            ['name' => 'Roberto', 'email' => 'robertoguapomago@gmail.com', 'role' => 'comediante'],
            ['name' => 'Julian', 'email' => 'colombianoacido@gmail.com', 'role' => 'comediante'],
            ['name' => 'Danny', 'email' => 'boton@live.com.mx', 'role' => 'comediante'],
            ['name' => 'Alfaro', 'email' => 'juan.alfarotv@gmail.com', 'role' => 'comediante'],
            ['name' => 'Victor', 'email' => 'victormerk@hotmail.com', 'role' => 'comediante'],
            ['name' => 'Rolly', 'email' => 'rolando_emmanuel@hotmail.com', 'role' => 'comediante'],
            ['name' => 'Gama', 'email' => 'gmata@ascomediantes.mx', 'role' => 'comediante'],
            ['name' => 'Ricardo', 'email' => 'rcardenas@ascomediantes.mx', 'role' => 'viewer'],
            ['name' => 'Esmeralda', 'email' => 'ecardenas@ascomediantes.mx', 'role' => 'viewer'],
            ['name' => 'Nahum', 'email' => 'nmendoza@ascomediantes.mx', 'role' => 'viewer'],
            ['name' => 'Gabriel', 'email' => 'gmendoza@ascomediantes.mx', 'role' => 'viewer']
        ];

        foreach ($users as $key => $value) {
            $user = \App\User::create([
                'name' => $value['name'],
                'email' => $value['email'],
                'password' => bcrypt('123456'),
                'avatar' => 'avatar.png'
            ]);
            // Assign role
            $user->assignRole($value['role']);
            // Generate avatar to defautl user
            $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
            Storage::put('avatars/'.$user->id.'/avatar.png', (string) $avatar);
        }
    }
}
