<?php

namespace App\Http\Controllers\HistoriaClinica;

use Throwable;
use App\Models\Evolucion;
use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Traits\metodosComunesTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class HistoriaClinicaController extends Controller
{
    use metodosComunesTrait;

    public function __construct()
    {
        $this->middleware(['permission:LISTAR'])->only(['buscar','buscarEvolucion']);
        $this->middleware(['permission:CREAR'])->only('storeEvolucion');
        $this->middleware(['permission:EDITAR'])->only('updateEvolucion');
        $this->middleware(['permission:ELIMINAR'])->only('destroyEvolucion');
        $this->middleware(['permission:VER'])->only('showEvolucion');
    }

    /**
     * Método que busca registros de un paciente.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function buscar(Request $request)
    {

        // Se válida si envian los parámetros length y start.
        if ($request->has(['length', 'start'])) {
            $length = $request->length;
            $start  = $request->start;
        } else {
            $length = 15;
            $start  = 0;
        }

        $registros = Paciente::select('*');

        if ($request->tipo_documento != "") {
            $registros = $registros->where('tipo_documento','LIKE', "%$request->tipo_documento%");
        }
        if ($request->numero_documento != "") {
            $registros = $registros->where('numero_documento','LIKE', "%$request->numero_documento%");
        }
        if ($request->nombre != "") {
            $registros = $registros->where('nombre','LIKE', "%$request->nombre%");
        }
        if ($request->apellido != "") {
            $registros = $registros->where('apellido','LIKE', "%$request->apellido%");
        }

        $registros = $registros->Ordenamiento($request->orderColumn, $request->order);

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

    /**
     * Undocumented function
     *
     * @return \Illuminate\Http\Response
     */
    public function buscarEvolucion(Request $request,$numero_documento){

        if ($numero_documento == "") {
            return response()->json([
                'message' => 'Error de Validación',
                'errors'  => "El Numero de Documento del paciente no puede ser vacío."
            ], 409);
        }

        // Se válida si envian los parámetros length y start.
        if ($request->has(['length', 'start'])) {
            $length = $request->length;
            $start  = $request->start;
        } else {
            $length = 15;
            $start  = 0;
        }

        $paciente = Paciente::select([
            'id',
            'numero_documento',
            'nombre',
            'apellido',
            'foto'
        ])
        ->where('numero_documento', $numero_documento)
        ->first();

        if (!$paciente) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors'  => "El Paciente[$numero_documento] no existe."
            ], 404);
        }

        $evoluciones = Evolucion::where('id_paciente', $paciente->id)
            ->Buscar($request->buscar)
            ->Ordenamiento($request->orderColumn, $request->order)
            ->with([
                'getPaciente' => function ($query){
                    $query->select([
                        'id',
                        'numero_documento',
                        'nombre',
                        'apellido',
                        'foto'
                    ]);
                }
            ]);

        // consulta para saber cuantos registros hay.
        $totalRegistros = $evoluciones->count();

        if ($totalRegistros == 0) {
            return response()->json([
                'data'      => [
                    ["get_paciente" => $paciente]
                ],
                'filtrados' => 0,
                'total'     => 0,
            ], 200);
        }

        $registros = $evoluciones->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'data'      => $registros,
            'filtrados' => $registros->count(),
            'total'     => $totalRegistros,
        ], 200);
    }

    /**
     * Muestra una evolucion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showEvolucion($id)
    {
        $evolucion = Evolucion::findOrfail($id);
        $evolucion->hora = substr($evolucion->hora,0,5);

        return response()->json([
            'data'      => $evolucion,
        ], 200);
    }

    /**
     * Método que descarga un archivo.
     *
     * @param Request $request
     * @return string
     */
    public function descargar(Request $request)
    {
        // Ruta archivo
        $path = public_path($request->path).$request->nombreArchivo;
        return response()->download($path, $request->nombreArchivo);
    }
}
