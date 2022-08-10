<?php

namespace App\Http\Controllers\Agenda;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\AlertaCita;
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
                "fecha_reporte"     => "required|date_format:Y-m-d"
            ],
            [
                "tipo_informe_cita.required"    => "El tipo de informe de cita es requerido",
                "fecha_reporte.required"        => "La fecha de reporte es requerida",
                'fecha_reporte.date_format'     => 'La fecha de reporte no coincide con el formato Y-m-d',
            ]
        );

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
                        'getPaciente' => function ($query) {
                            $query->select([
                                'id',
                                'numero_documento',
                                'nombre',
                                'apellido',
                                'celular',
                                'id_p_eps'
                            ])
                                ->with([
                                    'getEps' => function ($query) {
                                        $query->select([
                                            'id',
                                            'descripcion'
                                        ]);
                                    }
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
     * Método que actualiza cita de paciente, dependiente el tipo de marcación enviado. "SI" o "NO"
     *
     * @param Request $request
     * @param CitaPaciente $cita
     * @return void
     */
    public function marcarCita(Request $request, CitaPaciente $cita)
    {

        switch ($request->tipo_marcacion) {
            case 'ASISTIOCITA':
                $estadoCita = $cita->asistio != "SI" ? "SI" : "NO";
                $cita->update([
                    "asistio" => $estadoCita
                ]);
                break;
            case 'PRIORITARIA':
                $prioritarioCita = $cita->prioridad != "SI" ? "SI" : "NO";

                if ($prioritarioCita == "NO") {
                    $id_alerta_cita = $cita->id_alerta_cita;
                    $cita->update([
                        "prioridad"         => $prioritarioCita,
                        "id_alerta_cita"    => null
                    ]);
                    try {
                        // Se elimina alerta solo cuando a la cita se quite el check de prioridad.
                        AlertaCita::find($id_alerta_cita)->delete();
                    } catch (Exception $e) {
                        return response()->json([
                            'message' => 'Error inesperado en el sistema',
                            'errors' => "No se pudo eliminar alerta id $id_alerta_cita."
                        ], 500);
                    }
                } else {
                    $vNotificacion = $this->notificacion($request->tipo_alerta);
                    if ($vNotificacion[0] == "false") {
                        return response()->json([
                            'message' => 'Error inesperado en el sistema',
                            'errors' => "Error al crear notificación."
                        ], 500);
                    }

                    // Si se marca en SI prioritaria cita se asocia notificación.
                    $cita->update([
                        "prioridad"      => $prioritarioCita,
                        "id_alerta_cita" => $vNotificacion[1]
                    ]);
                }

                break;
            default:
                return response()->json([
                    'message' => 'Validación de Datos',
                    'errors' => "No se encontro parametrizado el tipo de marcación en el sistema $request->tipo_marcacion"
                ], 409);
                break;
        }

        return response()->json([
            'message' => 'Cita Actualizada.',
        ], 201);
    }

    /**
     * Método que actualiza cita de paciente, dependiente el tipo de marcación enviado. "SI" o "NO"
     *
     * @param Request $request
     * @param CitaPaciente $cita
     * @return void
     */
    public function notificacion($tipo_alerta)
    {

        $mReturn[0] = ""; // Estado
        $mReturn[1] = ""; // Id Alerta
        $mReturn[2] = ""; // Errores
        try {
            $alertaCita = AlertaCita::create([
                "tipo_alerta"   => $tipo_alerta
            ]);
            $mReturn[0] = "true";
            $mReturn[1] = $alertaCita->id;
        } catch (Exception $e) {
            $mReturn[0] = "false";
            $mReturn[2] = "Errores al crear alerta cita: " . $e;
        }

        return $mReturn;
    }

    public function valorCita(Request $request, CitaPaciente $cita)
    {
        $errores = [];
        $validator = Validator::make(
            $request->all(),
            [
                'valor'            => 'nullable|numeric|regex:/^[\d]{0,9}(\.[\d]{1,2})?$/'
            ],
            [
                'valor.numeric'    => 'El valor de la cita debe ser un dato númerico.',
                'valor.regex'      => 'El valor de la cita no puede tener 9 digitos entreros y 2 decimales máximo.',
            ]
        );

        if ($validator->fails()) {
            $errores = $validator->errors();
        }

        if (count($errores) > 0) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors' => $errores
            ], 422);
        }

        $cita->update([
            "valor" => $request->valor
        ]);

        return response()->json([
            'message' => 'Cita Actualizada.',
        ], 201);
    }
}
