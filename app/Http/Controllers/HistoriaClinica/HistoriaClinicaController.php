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
     * Guardar evolución.
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

        // consultando que exista el paciente
        $paciente = Paciente::select('id')->where('numero_documento', $request->numero_documento)->first();
        if (!$paciente) {
            return response()->json([
                'message' => 'Validación de Datos',
                'errors' => "No existe un paciente con el Número de Documento[$request->numero_documento]."
            ], 409);
        }

        // Validando refracciones.
        if($request->hasFile('refracciones')){
            foreach($request->file('refracciones') as $file){
                $validator = Validator::make(
                                    [
                                        "url_refraccion" => $file
                                    ],
                                    [
                                        'url_refraccion' => 'mimes:jpg,jpeg,png'
                                    ],
                                    Evolucion::$messages);
                if ($validator->fails()) {
                    $errores = $validator->errors();
                }
            }
        }
        // else{
        //     if (empty($errores)) {
        //         $errores['url_refraccion'] = [
        //             'La refracción es requerida.'
        //         ];
        //     }else{
        //         $errores->add('url_refraccion', 'La refracción es requerida.');
        //     }
        // }

        if (count($errores) > 0) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors' => $errores
            ], 422);
        }

        try {

            if (!file_exists(public_path('storage/img-refracciones-temporal'))) {
                File::makeDirectory(public_path('storage/img-refracciones-temporal'), 0777);
            }
            if (!file_exists(public_path('storage/refracciones'))) {
                File::makeDirectory(public_path('storage/refracciones'), 0777);
            }

            $numeroEvolucion = $this->obtenerNumeroEvolucion($paciente->id);
            $nombrePdf = null;

            if($request->hasFile('refracciones')){

                // Procesando imagenes para crear pdf con refracciones subida.
                $vReturnPdfRefracciones = $this->fnPdfRefracciones($request, $numeroEvolucion);

                if ($vReturnPdfRefracciones[0] == "false") {
                    return response()->json([
                        'message' => 'Error inesperado.',
                        'errors' => "Error al procesar archivos refracciones, por favor comuniquese con el area de Tecnología, Gracias.".$vReturnPdfRefracciones[2]
                    ], 500);
                }else{
                    $nombrePdf = $vReturnPdfRefracciones[1];
                }

            }

            Evolucion::create([
                "id_paciente"       => $paciente->id,
                "numero_evolucion"  => $numeroEvolucion,
                "url_refraccion"    => $nombrePdf,
                "fecha"             => $request->fecha,
                "hora"              => $request->hora.":00",
                "descripcion"       => trim(strtoupper($this->fnEliminarTildes($request->descripcion)))
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Error inesperado',
                'errors' => [
                    'Error al Guardar datos.'.$e
                ]
            ], 500);
        }
        return response()->json([
            'message' => 'Datos Guardados.',
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEvolucion(Request $request, $id)
    {
        $errores = [];
        $validator = Validator::make(
                                    $request->all(),
                                    Evolucion::fnRulesUpdate(),
                                    Evolucion::$messages);
        if ($validator->fails()) {
            $errores = $validator->errors();
        }

        // Validando refracciones.
        if($request->hasFile('refracciones')){
            foreach($request->file('refracciones') as $file){
                $validator = Validator::make(
                                    [
                                        "url_refraccion" => $file
                                    ],
                                    [
                                        'url_refraccion' => 'mimes:jpg,jpeg,bmp,png'
                                    ],
                                    Evolucion::$messages);
                if ($validator->fails()) {
                    $errores = $validator->errors();
                }
            }
        }

        if (count($errores) > 0) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors' => $errores
            ], 422);
        }

        $evolucion = Evolucion::findOrfail($id);

        if ($evolucion) {

            $nombrePdf = null; // Variable para guardar el nombre del archivo PDF.

            // Determina si el parametro está ausente.
            if ($request->missing('refracciones')) {
                $nombrePdf = $evolucion->url_refraccion;
            }else{

                if($request->hasFile('refracciones')){

                    // Eliminando PDF, porque se subieron refracciones nuevas.
                    File::delete(public_path('storage/refracciones/').$evolucion->url_refraccion);

                    // Procesando imagenes para crear pdf con refracciones subida.
                    $vReturnPdfRefracciones = $this->fnPdfRefracciones($request, $evolucion->numero_evolucion);

                    if ($vReturnPdfRefracciones[0] == "false") {
                        return response()->json([
                            'message' => 'Error inesperado.',
                            'errors' => "Error al procesar archivos refracciones, por favor comuniquese con el area de Tecnología, Gracias.".$vReturnPdfRefracciones[2]
                        ], 500);
                    }else{
                        $nombrePdf = $vReturnPdfRefracciones[1];
                    }
                }else{
                    try {
                        // Eliminando PDF no se envío ninguna refracción
                        File::delete(public_path('storage/refracciones/').$evolucion->url_refraccion);
                    } catch (Throwable $e) {
                        return response()->json([
                            'message' => 'Error inesperado',
                            'errors' => [
                                'Error al eliminar PDF refracciones.'
                            ]
                        ], 500);
                    }
                }
            }

            try {
                // UPDATE
                $evolucion->update([
                    "fecha"          => $request->fecha,
                    "hora"           => $request->hora.":00",
                    "descripcion"    => trim(strtoupper($this->fnEliminarTildes($request->descripcion))),
                    "url_refraccion" => $nombrePdf,
                ]);

            } catch (Throwable $e) {
                return response()->json([
                    'message' => 'Error inesperado',
                    'errors' => [
                        'Error al Actualizar datos.'
                    ]
                ], 500);
            }
        }
        return response()->json([
            'message' => "Datos Actualizados con exito.",
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyEvolucion($id)
    {
        $evolucion = Evolucion::findOrfail($id);
        if ($evolucion) {
            try {
                // Eliminando PDF Refracciones.
                File::delete(public_path('storage/refracciones/').$evolucion->url_refraccion);
                $evolucion->delete();
            } catch (Throwable $e) {
                return response()->json([
                    'message' => 'Error inesperado en el Sistema',
                    'errors' => "Error al eliminar Evolucion del paciente."
                ], 500);
            }

            return response()->json([
                'message' => "La Historia No.[$evolucion->numero_evolucion] ha sido eliminada.",
            ], 201);
        }
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

        if(!$numeroEvoluciones){
            $numero_evolucion = "0000";
        }else{
            $numero_evolucion = $numeroEvoluciones->numero_evolucion;
        }

        $consecutivoNumeroEvolucion = intval($numero_evolucion)+1;
        return str_pad(strval($consecutivoNumeroEvolucion), 4,"0",STR_PAD_LEFT);
    }
}
