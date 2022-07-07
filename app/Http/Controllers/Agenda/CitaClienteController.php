<?php

namespace App\Http\Controllers\Agenda;

use Exception;
use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Models\CitaPaciente;
use App\Traits\metodosComunesTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CitaClienteController extends Controller
{
    use metodosComunesTrait;

    /**
     * Método que lista todos los registros.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function listar(Request $request)
    {

        // Se válida si envian los parámetros length y start.
        if ($request->has(['length', 'start'])) {
            $length = $request->length;
            $start  = $request->start;
        } else {
            $length = 15;
            $start  = 0;
        }

        $citas_pacientes = DB::table('cita_paciente')
            ->join('paciente', 'cita_paciente.id_paciente', '=', 'paciente.id')
            ->join('p_eps', 'paciente.id_p_eps', '=', 'p_eps.id')
            // Buscar
            ->where(function($query) use($request) {
                $query  ->where('paciente.numero_documento', 'LIKE', "%$request->buscar%")
                        ->orWhere('paciente.nombre', 'LIKE', "%$request->buscar%")
                        ->orWhere('paciente.apellido', 'LIKE', "%$request->buscar%")
                        // ->orWhere('paciente.celular', 'LIKE', "%$request->buscar%")
                        ->orWhere('cita_paciente.tipo_consulta', 'LIKE', "%$request->buscar%")
                        ->orWhere('cita_paciente.fecha_cita', 'LIKE', "%$request->buscar%")
                        ->orWhere('cita_paciente.hora_cita', 'LIKE', "%$request->buscar%")
                        ->orWhere('cita_paciente.updated_at', 'LIKE', "%$request->buscar%")
                        ->orWhere('p_eps.descripcion', 'LIKE', "%$request->buscar%");
            });
            // Ordenamiento
            if($request->orderColumn != "" && $request->order != ""){
                $citas_pacientes = $citas_pacientes->orderBy($request->orderColumn, $request->order);
            }

        // consulta para saber cuantos registros hay.
        $totalRegistros = $citas_pacientes->count();

        $registros = $citas_pacientes->skip($start)
            ->take($length)
            ->selectRaw(
                "paciente.numero_documento,
                CONCAT(paciente.nombre,\" \",paciente.apellido) as nombre_apellido,
                paciente.celular,
                cita_paciente.id,
                cita_paciente.tipo_consulta,
                cita_paciente.fecha_cita,
                cita_paciente.hora_cita,
                cita_paciente.updated_at,
                p_eps.descripcion as eps")
            ->get();

        return response()->json([
            'data'      => $registros,
            'filtrados' => $registros->count(),
            'total'     => $totalRegistros,
        ], 200);
    }

    /**
     * Método que guarda cita para un paciente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errores = [];
        $validator = Validator::make(
                                    $request->all(),
                                    CitaPaciente::$rulesStore,
                                    CitaPaciente::$messages);

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
                'errors' => "No existe un paciente con el Número de Documento [$request->numero_documento]."
            ], 409);
        }

        try {
            $request->merge([
                'id_paciente'               => $paciente->id,
                'hora_cita'                 => $request->hora_cita.":00"
            ]);
            $input = $request->collect();
            $input = $input->except(['numero_documento']);

            $data = $input->map(function ($valor, $key) {
                if ($key == "observacion" && $valor != "") {
                    $valor = trim(strtoupper($this->fnEliminarTildes($valor)));
                }else if($valor != ""){
                    $valor = trim($valor);
                }
                return $valor;
            })->all();

            CitaPaciente::create($data);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error inesperado',
                'errors' => 'Error al Guardar datos.'.$e
            ], 500);
        }

        return response()->json([
            'message' => 'Datos Guardados.',
        ], 201);
    }

    /**
     * Muestra cita de una paciente en específico.
     *
     * @param  int  $id Unico de la cita
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $citaPaciente = CitaPaciente::where('id',$id)
        ->with([
            'getPaciente' => function ($query){
                $query->select([
                    'id',
                    'numero_documento',
                    'nombre',
                    'apellido'
                ]);
            }
        ])
        ->first();

        return response()->json([
            'data'      => $citaPaciente,
        ], 200);
    }

    /**
     * Método que actualiza cita.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id Unico cita
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $citaPaciente = CitaPaciente::findOrfail($id);

        $errores = [];
        $validator = Validator::make(
                                    $request->all(),
                                    CitaPaciente::$rulesStore,
                                    CitaPaciente::$messages);
        if ($validator->fails()) {
            $errores = $validator->errors();
        }

        if (count($errores) > 0) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errores' => $errores
            ], 422);
        }

        if ($request->filled('numero_documento')) {
            // consultando que exista el paciente
            $paciente = Paciente::select('id')->where('numero_documento', $request->numero_documento)->first();
            if (!$paciente) {
                return response()->json([
                    'message' => 'Validación de Datos',
                    'errors' => "No existe un paciente con el Número de Documento [$request->numero_documento]."
                ], 409);
            }else if ($paciente->id != $citaPaciente->id_paciente) {
                // Si se cambio el paciente para la cita.
                $request->merge(['id_paciente' => $paciente->id,]);
            }
        }

        if ($citaPaciente) {

            try {
                $input = $request->collect();
                $input = $input->except(['numero_documento']);

                $data = $input->map(function ($valor, $key) {
                    if ($key == "observacion" && $valor != "") {
                        $valor = trim(strtoupper($this->fnEliminarTildes($valor)));
                    }else if($valor != ""){
                        $valor = trim($valor);
                    }
                    return $valor;
                })->all();

                $citaPaciente->update($data);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Error en el Sistema',
                    'errors'  => [
                        "Error al actualizar Cita Paciente, por favor comuniquese con el area de Tecnología, Gracias."
                    ]
                ], 500);
            }
        }

        return response()->json([
            'message' => "Datos Actualizados con exito.",
        ], 201);
    }

    /**
     * Método que elimina cita
     *
     * @param  int  $id Unico cita
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $citaPaciente = CitaPaciente::where('id',$id)->first();
        if ($citaPaciente) {
            $paciente = Paciente::findOrfail($citaPaciente->id_paciente);
            try {
                // Eliminando
                $citaPaciente->delete();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Error inesperado en el Sistema',
                    'errors' => "Error al eliminar Cita para el Pacientecon número de identificación: $paciente->numero_documento."
                ], 500);
            }

            return response()->json([
                'message' => "La Cita del Paciente con número de identificación $paciente->numero_documento ha sido eliminada.",
            ], 201);
        }else{
            return response()->json([
                'message' => 'Validación de Datos',
                'errors' => "No existe Cita Paciente intenta eliminar, verifique."
            ], 404);
        }
    }

    /**
     * Busca por identificación, Nombre y apellido del paciente.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function busquedaAutocompletePaciente(Request $request) { // metodos comunes
        if (strlen($request->valor) < 2) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors' => [
                    "numero_documento" => [
                        "Para realizar la busqueda del paciente, el numero de documento debe tener minimo dos carácteres."
                    ]
                ]
            ], 422);
        }
        $registros = Paciente::select([
                'id',
                'numero_documento',
                'nombre',
                'apellido'
            ])
            ->where(function ($query) use ($request) {
                $query  ->where('numero_documento', 'like', $request->valor.'%')
                        ->orWhere('nombre', 'like', $request->valor.'%')
                        ->orWhere('apellido', 'like', $request->valor.'%');
            });

        $registros = $registros->get();

        $registros = $registros->map(function ($registro, $key) {
            return [
                "id" =>  $registro->numero_documento,
                'description'  => $registro->numero_documento."-".$registro->nombre." ".$registro->apellido
            ];
        });

        return response()->json([
            'data' => $registros
        ], 200);
    }

    /**
     * Método que busca un paciente y retorna la información.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function cargarInfoPaciente(Request $request) {// metodos comunes
        $paciente = Paciente::where('numero_documento', $request->numero_documento)->first();
        return response()->json([
            'data' => $paciente
        ], 200);
    }
}
