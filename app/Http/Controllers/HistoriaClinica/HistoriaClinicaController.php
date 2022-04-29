<?php

namespace App\Http\Controllers\HistoriaClinica;

use Throwable;
use App\Models\Evolucion;
use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Traits\metodosComunesTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HistoriaClinicaController extends Controller
{
    use metodosComunesTrait;
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

        $bRequestVacio = true;
        $registros = Paciente::select('*');

        if ($request->tipo_documento != "") {
            $bRequestVacio = false;
            $registros = $registros->where('tipo_documento','LIKE', "%$request->tipo_documento%");
        }
        if ($request->numero_documento != "") {
            $bRequestVacio = false;
            $registros = $registros->where('numero_documento','LIKE', "%$request->numero_documento%");
        }
        if ($request->nombre != "") {
            $bRequestVacio = false;
            $registros = $registros->where('nombre','LIKE', "%$request->nombre%");
        }
        if ($request->apellido != "") {
            $bRequestVacio = false;
            $registros = $registros->where('apellido','LIKE', "%$request->apellido%");
        }

        // Si no se envia ningun request.
        if ($bRequestVacio == true && $request->listar_todos != "SI") {
            return response()->json([
                'data'      => [],
                'filtrados' => 0,
                'total'     => 0
            ], 200);
        }else{
            $registros = $registros->Ordenamiento($request->orderColumn, $request->order);

            // consulta para saber cuantos registros hay.
            $totalRegistros = $registros->count();

            $registros = $registros->skip($start)
                ->take($length)
                ->get();
        }

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
                'errors'  => "La Evolución del paciente no puede ser vacía."
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeEvolucion(Request $request)
    {
        $errores = [];
        $validator = Validator::make(
                                    $request->all(),
                                    Evolucion::$rulesStore,
                                    Evolucion::$messages);
        if ($validator->fails()) {
            $errores = $validator->errors();
        }

        if (count($errores) > 0) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errores' => $errores
            ], 422);
        }

        // consultando que exista el paciente
        $paciente = Paciente::select('id')->where('numero_documento', $request->numero_documento)->first();
        if (!$paciente) {
            return response()->json([
                'message' => 'Validación de Datos',
                'errores' => "No existe un paciente con el Número de Documento[$request->numero_documento]."
            ], 409);
        }

        try {

            $urlRefraccion = $this->guardarArchivoSubido($request, "foto", "historia-clinica/refracciones");

            Evolucion::create([
                "id_paciente"       => $paciente->id,
                "numero_evolucion"  => $this->obtenerNumeroEvolucion($paciente->id),
                "url_refraccion"    => "babarasbasada",
                "fecha"             => $request->fecha,
                "hora"              => $request->hora,
                "descripcion"       => $request->descripcion
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Error inesperado',
                'errores' => [
                    'Error al Guardar datos.'
                ]
            ], 500);
        }
        return response()->json([
            'message' => 'Datos Guardados.',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Nétodo que retorna el consecutivo de numero de evolucion para la historia clinica del paciente en evolucion
     *
     * @param integer $id_paciente
     * @return string consecutivo Historia clinica evolucion
     */
    public function obtenerNumeroEvolucion($id_paciente){
        $numeroEvoluciones = Evolucion::select('numero_evolucion')
            ->where('id_paciente', $id_paciente)
            ->orderBy('id', 'desc')
            ->first();

        $consecutivoNumeroEvolucion = intval($numeroEvoluciones->numero_evolucion)+1;
        return str_pad(strval($consecutivoNumeroEvolucion), 4,"0",STR_PAD_LEFT);
    }
}

