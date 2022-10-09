<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
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

    /**
     * Retorna listado de permisos permisos.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function listarPermisos(){
        $permisos = Permission::select(['id', 'name'])->get();
        return response()->json([
            'message' => 'Permisos.',
            'data' => $permisos
        ], 200);
    }

    /**
     * Retorna listado de permisos permisos.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function listarPermisosRol($id){
        try {
            $role = Role::find($id);
            // get collection
            $role->permissions;
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error inesperado',
                'errors' => [
                    'Error al listar permisos del Rol.'.$e
                ]
            ], 500);
        }
        return response()->json([
            'message' => "Permisos Rol $role->name.",
            'data' => $role->permissions->pluck('name')
        ], 200);
    }

    /**
     * Guarda permisos a un rol.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeRolPermisos(Request $request)
    {
        $idRol = $request->idRol;
        $rol = Role::findOrFail($idRol);
        try {
            $vIdPermisos = [];
            $request = $request->except(['idRol']);
            foreach ($request as $permiso) {
                array_push($vIdPermisos,$permiso);
            }
            $rol->syncPermissions($vIdPermisos);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error inesperado',
                'errors' => [
                    'Error al guardar permisos.'.$e
                ]
            ], 500);
        }
        return response()->json([
            'message' => "Permisos para el Rol $rol->name guardados con éxito.",
        ], 201);
    }
}
