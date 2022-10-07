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

        $mPermisos = [
            [
                'id'      => '1',
                'name'      => 'LISTAR'
            ],
            [
                'id'      => '2',
                'name'      => 'CREAR'
            ],
            [
                'id'      => '3',
                'name'      => 'EDITAR'
            ],
            [
                'id'      => '4',
                'name'      => 'ELIMINAR'
            ],
            [
                'id'      => '5',
                'name'      => 'VER'
            ]
        ];

        $vIdPermisos = [];
        foreach ($mPermisos as $vPermiso) {
            $exists = Permission::firstOrCreate([
                'id' => $vPermiso['id']
            ], $vPermiso);
            array_push($vIdPermisos,$exists);
        }

        $mRoles = [
            [
                'id'      => '1',
                'name'      => 'SECRETARIA'
            ],
            [
                'id'      => '2',
                'name'      => 'MEDICO'
            ],
            [
                'id'      => '3',
                'name'      => 'ADMINISTRADOR'
            ],
        ];

        foreach ($mRoles as $vRol) {
            $rol = Role::firstOrCreate([
                'id' => $vRol['id']
            ], $vRol);
            $rol->syncPermissions($vIdPermisos);
        }

        $user = User::find(1);
        if (!$user) {
            $user = User::create([
                'id'        => "1",
                'name'      => 'Vicky Aldana',
                'email'     => 'vickyaldana31@gmail.com',
                'password'  => Hash::make('admin123'),
            ]);
            $user->assignRole('SECRETARIA');
        }else{
            $user->assignRole('SECRETARIA');
        }

        $user = User::find(2);
        if (!$user) {
            $user = User::create([
                'id'        => "2",
                'name'      => 'Consultorio',
                'email'     => 'consultoriodoctorpuentes@gmail.com',
                'password'  => Hash::make('admin123'),
            ]);
            $user->assignRole('SECRETARIA');
        }else{
            $user->assignRole('SECRETARIA');
        }

        $user = User::find(3);
        if (!$user) {
            $user = User::create([
                'id'        => "3",
                'name'      => 'Luis Puentes',
                'email'     => 'puentes222@hotmail.com',
                'password'  => Hash::make('admin123'),
            ]);
            $user->assignRole('MEDICO');
        }else{
            $user->assignRole('MEDICO');
        }

        $user = User::find(4);
        if (!$user) {
            $user = User::create([
                'id'        => "4",
                'name'      => 'ADMINISTRADOR',
                'email'     => 'administrador@gmail.com',
                'password'  => Hash::make('administrador')
            ]);
            $user->assignRole('ADMINISTRADOR');
        }else{
            $user->assignRole('ADMINISTRADOR');
        }
    }
}
