<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Retorna los permisos del usuario autenticado.
     *
     * @return string
     */
    public function buscaPermisosUsuario(){
        $users = User::findOrFail(Auth::user()->id);
        $permisos = $users->getAllPermissions()->pluck('name');
        return response()->json([
            'message' => 'Lista de Permisos de usuario.',
            'data' => $permisos
        ], 200);
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
