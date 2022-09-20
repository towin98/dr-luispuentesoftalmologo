<?php

namespace App\Http\Controllers\Auditing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Models\Audit;

class AuditingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:LISTAR'])->only('buscar');
    }

    /**
     * Método que busca registros, lista registros en la tabla de Auditing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function auditingListar(Request $request){

        // Se válida si envian los parámetros length y start.
        if($request->has(['length', 'start'])){
            $length = $request->length;
            $start  = $request->start;
        }else{
            $length = 15;
            $start  = 0;
        }

        $audits = DB::table('audits')
            ->join('users', 'audits.user_id', '=', 'users.id')
            // Buscar
            ->where(function($query) use($request) {
                if ($request->buscar != "") {
                    $query  ->where('users.name', 'LIKE', "%$request->buscar%")
                            ->orWhere('users.email', 'LIKE', "%$request->buscar%")
                            ->orWhere('audits.tags', 'LIKE', "%$request->buscar%")
                            ->orWhere('audits.event', 'LIKE', "%$request->buscar%")
                            ->orWhere('audits.auditable_id', 'LIKE', "%$request->buscar%")
                            ->orWhere('audits.old_values', 'LIKE', "%$request->buscar%")
                            ->orWhere('audits.new_values', 'LIKE', "%$request->buscar%")
                            ->orWhere('audits.url', 'LIKE', "%$request->buscar%")
                            ->orWhere('audits.user_agent', 'LIKE', "%$request->buscar%")
                            ->orWhere('audits.created_at', 'LIKE', "%$request->buscar%");
                }else{
                    return $query;
                }
            });

        // Ordenamiento
        if($request->orderColumn != "" && $request->order != ""){
            switch ($request->orderColumn) {
                case 'name':
                case 'email':
                    $audits = $audits->orderBy("users.".$request->orderColumn, $request->order);
                break;
                default:
                    $audits = $audits->orderBy("audits.".$request->orderColumn, $request->order);
                break;
            }
        }

        // consulta para saber cuantos registros hay.
        $totalRegistros = $audits->count();

        $registros = $audits->skip($start)
            ->take($length)
            ->selectRaw(
                "audits.id,
                audits.user_id,
                users.name,
                users.email,
                audits.tags,
                audits.event,
                audits.auditable_id,
                audits.old_values,
                audits.new_values,
                audits.url,
                audits.user_agent,
                audits.created_at")
            ->get();

        return response()->json([
            'data'      => $registros,
            'filtrados' => $registros->count(),
            'total'     => $totalRegistros,
        ], 200);
    }
}
