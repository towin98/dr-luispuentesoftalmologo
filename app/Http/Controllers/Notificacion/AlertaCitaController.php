<?php

namespace App\Http\Controllers\Notificacion;

use App\Http\Controllers\Controller;
use App\Models\AlertaCita;
use App\Models\CitaPaciente;
use Illuminate\Http\Request;

class AlertaCitaController extends Controller
{
    /**
     * Método que retorna citas con alertas para notificar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listarCitasConALerta(Request $request)
    {
        $registros = CitaPaciente::select(['id', 'id_alerta_cita', 'id_paciente', 'fecha_cita', 'hora_cita', 'prioridad_aceptado', 'observacion'])
            ->where('prioridad', 'SI')
            ->where('id_alerta_cita', '!=' , null)
            ->where('id_alerta_cita', '!=' , '')
            ->with('getAlertaCita');

        $totalCitasConNotificacion = $registros->count();

        if ($request->listar == "SI") {

            if (!$request->filled('length') || !$request->filled('start')) {
                return response()->json([
                    'message' => 'Validación de datos',
                    'errors'  => "No se enviaron parámetros completos al listar notificaciones, verifíque."
                ], 409);
            }

            $registrosData = $registros->orderBy('id_alerta_cita', 'desc')
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
                ])
                ->skip($request->start)
                ->take($request->length)
                ->get();
        }else{
            $registrosData = [];
        }

        $totalNotificacionesSinLeer = $registros->whereHas('getAlertaCita', function($queryHas){
                $queryHas->where('leido', null);
            })
            ->count();

        return response()->json([
            'data'                      => $registrosData,
            'notificacionesSinLeer'     => $totalNotificacionesSinLeer,
            'citasConNotificacion'      => $totalCitasConNotificacion
        ], 200);
    }

    /**
     * Método que retorna citas con alertas para notificar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notitifacionLeida(AlertaCita $alertaCita)
    {
        $leido = null;
        if ($alertaCita->leido == null) {
            $leido = date('Y-m-d H:i:s');
            $cReturnMensaje = "Notifcación leida.";
        }else{
            $cReturnMensaje = "Notifcación no leida.";
        }

        $alertaCita->update([
            "leido" => $leido
        ]);

        return response()->json([
            'message' => $cReturnMensaje
        ], 201);
    }

    /**
     * Método que consulta citas prioritarias Aceptadas en un rango de 20 segundos.
     *
     * @return \Illuminate\Http\Response
     */
    public function notificacionCitasPrioritariasAceptadasRealTime(){

        $fechaActual= date('Y-m-d H:i:s');
        $NuevaFecha = strtotime ( '-20 second' , strtotime ($fechaActual) ) ;
        $NuevaFecha = date ( 'Y-m-d H:i:s' , $NuevaFecha);

        $citasPrioritarias = CitaPaciente::select(['id', 'id_paciente','fecha_cita','hora_cita'])
            ->whereBetween('prioridad_aceptado',[$NuevaFecha,$fechaActual])
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
            ])
            ->get();
        return response()->json([
            'data'    => $citasPrioritarias,
        ], 200);
    }
}
