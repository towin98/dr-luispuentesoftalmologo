<?php

namespace App\Http\Controllers\HistoriaClinica;

use Exception;
use App\Models\Evolucion;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\metodosComunesTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EvolucionController extends Controller
{
    use metodosComunesTrait;
    /**
     * Método que lista evoluciones que pertecen a una historia clinica.
     *
     * @return \Illuminate\Http\Response
     */
    public function listar(Request $request,$numero_documento){

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
            'fecha_nacimiento',
            'edad'
        ])
        ->where('numero_documento', $numero_documento)
        ->first();

        if (!$paciente) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors'  => "El Paciente[$numero_documento] no existe."
            ], 404);
        }

        $evoluciones = Evolucion::where([
                'evo_id_paciente'         => $paciente->id,
                'evo_id_historia_clinica' => $request->evo_id_historia_clinica,
            ])
            ->Buscar($request->buscar)
            ->Ordenamiento($request->orderColumn, $request->order)
            ->with([
                'getPaciente' => function ($query){
                    $query->select([
                        'id',
                        'numero_documento',
                        'nombre',
                        'apellido',
                        'fecha_nacimiento',
                        'edad'
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
     * Mostrar evolución.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evolucion = Evolucion::findOrfail($id);

        return response()->json([
            'data'      => $evolucion,
        ], 200);
    }

    /**
     * Guarda Evolución.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
                'errors' => $errores
            ], 422);
        }

        // consultando que exista el paciente
        $paciente = Paciente::select('id')->where('numero_documento', $request->numero_documento)->first();
        if (!$paciente) {
            return response()->json([
                'message' => 'Validación de Datos',
                'errors' => "No existe un paciente con el Número de Documento[$request->numero_documento]."
            ], 409);
        }

        try {
            //Se crea variable de request
            $requestConsecutivoEvolucion = new Request();

            $requestConsecutivoEvolucion->merge([
                'evo_id_paciente'           => $paciente->id,
                'evo_id_historia_clinica'   => $request->evo_id_historia_clinica,
            ]);

            $consecutivoEvolucion = $this->obtenerConsecutivoEvolucion($requestConsecutivoEvolucion);

            Evolucion::create([
                'evo_id_paciente'               => $paciente->id,
                'evo_id_historia_clinica'       => $request->evo_id_historia_clinica,
                'evo_consecutivo'               => $consecutivoEvolucion,
                'evo_fecha_diligenciamiento'    => $request->evo_fecha_diligenciamiento,
                'evo_descripcion_evolucion'     => trim(strtoupper($this->fnEliminarTildes($request->evo_descripcion_evolucion))),
                'evo_tratamiento'               => trim(strtoupper($this->fnEliminarTildes($request->evo_tratamiento))),
                'evo_orden_medica'              => trim(strtoupper($this->fnEliminarTildes($request->evo_orden_medica)))
            ]);

        } catch (Exception $e) {
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
     * Actualiza Evolución
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $errores = [];
        $validator = Validator::make(
                                    $request->all(),
                                    Evolucion::$rulesUpdate,
                                    Evolucion::$messages);
        if ($validator->fails()) {
            $errores = $validator->errors();
        }

        if (count($errores) > 0) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors' => $errores
            ], 422);
        }

        $evolucion = Evolucion::findOrfail($id);

        try {
            $evolucion->update([
                'evo_fecha_diligenciamiento'    => $request->evo_fecha_diligenciamiento,
                'evo_descripcion_evolucion'     => trim(strtoupper($this->fnEliminarTildes($request->evo_descripcion_evolucion))),
                'evo_tratamiento'               => trim(strtoupper($this->fnEliminarTildes($request->evo_tratamiento))),
                'evo_orden_medica'              => trim(strtoupper($this->fnEliminarTildes($request->evo_orden_medica)))
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error inesperado',
                'errors' => [
                    'Error al Actualizar datos.'
                ]
            ], 500);
        }
        return response()->json([
            'message' => "Datos Actualizados con exito.",
        ], 201);
    }

    /**
     * Eliminar Evolución
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evolucion = Evolucion::findOrfail($id);
        if ($evolucion) {
            try {
                $evolucion->delete();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Error inesperado en el Sistema',
                    'errors' => "Error al eliminar Evolución $evolucion->evo_consecutivo."
                ], 500);
            }

            return response()->json([
                'message' => "La Evolución No.[$evolucion->evo_consecutivo] ha sido eliminada.",
            ], 201);
        }
    }

    /**
     * Nétodo que retorna el consecutivo de numero de evolución.
     *
     * @param integer $evo_id_paciente
     * @return string consecutivo Historia clinica evolucion
     */
    public function obtenerConsecutivoEvolucion(Request $request){
        $consecutivoEvolucion = Evolucion::select('evo_consecutivo')
            ->where('evo_id_paciente', $request->evo_id_paciente)
            ->where('evo_id_historia_clinica', $request->evo_id_historia_clinica)
            ->orderBy('evo_id', 'desc')
            ->first();

        if(!$consecutivoEvolucion){
            $evo_consecutivo = "0000";
        }else{
            $evo_consecutivo = $consecutivoEvolucion->evo_consecutivo;
        }

        $consecutivoNumeroEvolucion = intval($evo_consecutivo)+1;
        return str_pad(strval($consecutivoNumeroEvolucion), 4,"0",STR_PAD_LEFT);
    }

    /**
     * Método que genera reporte en PDF de Formula y Orden Medica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reportePdfEvolucion(Request $request){
        $mData = [];

        $paciente = Paciente::select([
            'id',
            'numero_documento',
            'nombre',
            'apellido',
        ])
        ->where('numero_documento', $request->numero_documento)
        ->first();

        if (!$paciente) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors'  => "El Paciente con No Documento $request->numero_documento no existe."
            ], 404);
        }

        $evolucion = Evolucion::findOrFail($request->evo_id);

        switch ($request->tipo_reporte) {
            case 'formula':
                $mData['tipo_rerporte'] = 'formula';
                $mData['mostrar_info_centro'] = "";
                $data = [
                    "tratamiento"       => $evolucion->evo_tratamiento,
                    "pacienteCc"        => $paciente->numero_documento,
                    "nombrePaciente"    => $paciente->nombre." ".$paciente->apellido
                ];
                $mData['data'] = $data;
            break;
            case 'orden_medica':
                $mData['tipo_rerporte']       = 'orden_medica';
                $mData['mostrar_info_centro'] = $request->mostrar_info_centro;
                $data = [
                    "orden_medica"      => $evolucion->evo_orden_medica,
                    "pacienteCc"        => $paciente->numero_documento,
                    "nombrePaciente"    => $paciente->nombre." ".$paciente->apellido
                ];
                $mData['data'] = $data;
            break;
            default:
                return response()->json([
                    'message' => 'Validación de Datos',
                    'errors' => "No se encontro parámetrizado el tipo de reporte."
                ], 404);
            break;
        }
        $pdf = PDF::loadView('pdf.formulaAnteojos', ['mData' => $mData]);
        return $pdf->output();
    }
}
