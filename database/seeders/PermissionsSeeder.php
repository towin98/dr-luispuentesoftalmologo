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

        $idListar   = Permission::create(['name' => 'LISTAR']);
        $idCrear    = Permission::create(['name' => 'CREAR']);
        $idEditar   = Permission::create(['name' => 'EDITAR']);
        $idEliminar = Permission::create(['name' => 'ELIMINAR']);
        $idVer      = Permission::create(['name' => 'VER']);

        $permisosSecretaria = [$idListar, $idCrear, $idEditar, $idEliminar, $idVer];

        $permisosMedico = [$idVer, $idListar];
        // array_push($permisosMedico, Permission::create(['name' => 'VER']));

        $rol = Role::create(['name' => 'SECRETARIA']);
        $rol->syncPermissions($permisosSecretaria);

        $rol = Role::create(['name' => 'MEDICO']);
        $rol->syncPermissions($permisosMedico);

        $user = User::create([
            'name' => 'Vicky Aldana',
            'email' => 'vickyaldana31@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        $user->assignRole('SECRETARIA');

        $user = User::create([
            'name' => 'Consultorio',
            'email' => 'consultoriodoctorpuentes@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        $user->assignRole('SECRETARIA');

        $user = User::create([
            'name' => 'Luis Puentes',
            'email' => 'puentes222@hotmail.com',
            'password' => Hash::make('admin123'),
        ]);
        $user->assignRole('MEDICO');
    }
}
