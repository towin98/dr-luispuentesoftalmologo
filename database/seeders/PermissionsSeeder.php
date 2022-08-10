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
        $permisos = [];
        array_push($permisos, Permission::create(['name' => 'LISTAR']));
        array_push($permisos, Permission::create(['name' => 'CREAR']));
        array_push($permisos, Permission::create(['name' => 'EDITAR']));
        array_push($permisos, Permission::create(['name' => 'ELIMINAR']));
        array_push($permisos, Permission::create(['name' => 'VER']));

        $rol = Role::create(['name' => 'SECRETARIA']);
        $rol->syncPermissions($permisos);

        $rol = Role::create(['name' => 'MEDICO']);
        $rol->syncPermissions($permisos);

        $user = User::create([
            'name' => 'Cristian Segura',
            'email' => 'segura9801@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        $user->assignRole('SECRETARIA');

        $user = User::create([
            'name' => 'Eduardo Martinez',
            'email' => 'eduardo@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        $user->assignRole('MEDICO');
    }
}
