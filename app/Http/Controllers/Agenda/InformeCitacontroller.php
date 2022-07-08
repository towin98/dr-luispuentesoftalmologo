<?php

namespace App\Http\Controllers\Agenda;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\CitaPaciente;
use Exception;
use Illuminate\Http\Request;

class InformeCitacontroller extends Controller
{
    /**
     * Método que busca citas.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscarCitas(Request $request)
    {
        $errores = [];
        $validator = Validator::make(
                                    $request->all(),
                                    [
                                        "tipo_informe_cita" => "required",
                                        "fecha_reporte" => "required|date_format:Y-m-d"
                                    ],
                                    [
                                        "tipo_informe_cita.required"        => "El tipo de informe de cita es requerido",
                                        "fecha_reporte.required"        => "La fecha de reporte es requerida",
                                        'fecha_reporte.date_format'     => 'La fecha de reporte no coincide con el formato Y-m-d',
                                    ]);

        if ($validator->fails()) {
            $errores = $validator->errors();
        }

        if (count($errores) > 0) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors' => $errores
            ], 422);
        }

        switch ($request->tipo_informe_cita) {
            case 'DIA':
                $citas = CitaPaciente::where('fecha_cita', $request->fecha_reporte)
                ->with([
                    'getPaciente' => function ($query){
                        $query->select([
                            'id',
                            'numero_documento',
                            'nombre',
                            'apellido',
                            'celular'
                        ]);
                    }
                ])
                ->orderBy('hora_cita', 'asc')->get();
            break;
            default:
            return response()->json([
                'message' => 'Validación de Datos',
                'errors' => "No se encontro parametrizado el tipo de informe solicitado[$request->tipo_informe_cita]."
            ], 409);
            break;
        }

        return response()->json([
            'data'      => $citas,
        ], 200);
    }

    /**
     * Método que actualiza cita de paciente, con estado asistio "SI" o "NO"
     *
     * @return \Illuminate\Http\Response
     */
    public function asistirCita(CitaPaciente $id_cita){
        if ($id_cita->asistio != "SI") {
            $estadoCita = "SI";
        }else{
            $estadoCita = "NO";
        }

        try {
            $id_cita->update([
                "asistio" => $estadoCita
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error inesperado',
                'errors' => 'Error al actualizar Estado Cita.'.$e
            ], 500);
        }

        return response()->json([
            'message' => 'Cita Actualizada.',
        ], 201);
    }

    
}
