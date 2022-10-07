<?php

namespace App\Http\Controllers\RolPermisos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role as ModelsRole;

class RolesPermisosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:LISTAR'])->only('rolesBuscar');
    }

    /**
     * Método que busca registros, lista registros en la tabla de Auditing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rolesBuscar(Request $request)
    {
        // Se válida si envian los parámetros length y start.
        if ($request->has(['length', 'start'])) {
            $length = $request->length;
            $start  = $request->start;
        } else {
            $length = 15;
            $start  = 0;
        }
        $registros = ModelsRole::select(['id', 'name', 'updated_at']);
        if ($request->buscar != "") {
            $registros->where('id', 'LIKE', "%$request->buscar%")
                    ->orWhere('name', 'LIKE', "%$request->buscar%")
                    ->orWhere('updated_at', 'LIKE', "%$request->buscar%");
        }

        // Ordenamiento
        if($request->orderColumn != "" && $request->order != ""){
            $registros = $registros->orderBy($request->orderColumn, $request->order);
        }

        // consulta para saber cuantos registros hay.
        $totalRegistros = $registros->count();

        $registros = $registros->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'data'      => $registros,
            'filtrados' => $registros->count(),
            'total'     => $totalRegistros,
        ], 200);
    }
}
