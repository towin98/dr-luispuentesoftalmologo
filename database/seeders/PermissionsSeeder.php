<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisosSecretaria = [];
        array_push($permisosSecretaria, Permission::create(['name' => 'LISTAR']));
        array_push($permisosSecretaria, Permission::create(['name' => 'CREAR']));
        array_push($permisosSecretaria, Permission::create(['name' => 'EDITAR']));
        array_push($permisosSecretaria, Permission::create(['name' => 'ELIMINAR']));
        array_push($permisosSecretaria, Permission::create(['name' => 'VER']));

        $permisosMedico = [];
        array_push($permisosMedico, Permission::create(['name' => 'VER']));

        $rol = Role::create(['name' => 'SECRETARIA']);
        $rol->syncPermissions($permisosSecretaria);

        $rol = Role::create(['name' => 'MEDICO']);
        $rol->syncPermissions($permisosMedico);

        $user = User::create([
            'name' => 'Cristian Segura',
            'email' => 'segura9801@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        $user->assignRole('SECRETARIA');

        $user = User::create([
            'name' => 'Eduardo Martinez',
            'email' => 'emartinezvi@sena.edu.co',
            'password' => Hash::make('admin123'),
        ]);
        $user->assignRole('MEDICO');
    }
}
