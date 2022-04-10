<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Verifica si el usuario tiene alguno de los roles.
     *
     * @param Request $request
     * @return boolean
     */
    public function canRol(Request $request) {

        // $users = User::findOrFail(Auth::user()->id);

        // $vRoles = explode(',',$request->roles);

        // for ($nR=0; $nR < count($vRoles); $nR++) {
        //     // Pregunta si tiene el rol
        //     if ($users->hasRole($vRoles[$nR])) {
        //         return response()->json([
        //             'data' => true
        //         ], 200);
        //     }
        // }

        // // Retorno false no tiene rol.
        // return response()->json([
        //     'data' => false
        // ], 200);
    }

    /**
     * Retorna nombre que tiene el usuario autenticado.
     *
     * @return string
     */
    public function informacionUsuario() {

        $users = User::findOrfail(Auth::user()->id);
        $cRol = $users->getRoleNames();

        return response()->json([
            'message' => 'Datos de usuario.',
            'data' => $users
        ], 200);
    }
}



        // $permisos = $users->getAllPermissions()->pluck('name');

        // foreach ($permisos as $permiso) {
        //     if ($permiso == $request->permiso) {
        //         return response()->json([
        //             'data' => true
        //         ], 200);
        //     }
        // }

        // if ($users->user()->currentAccessToken()) {
        //     return response()->json([
        //         'message' => 'Credenciales no validas',
        //         'data' => false
        //     ], 200);
        // }
