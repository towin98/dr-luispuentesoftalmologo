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
