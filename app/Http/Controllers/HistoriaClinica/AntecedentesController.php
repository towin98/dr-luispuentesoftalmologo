<?php

namespace App\Http\Controllers\HistoriaClinica;

use Exception;
use App\Models\Antecedente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Traits\metodosComunesTrait;
use Illuminate\Support\Facades\Validator;

class AntecedentesController extends Controller
{
    use metodosComunesTrait;

    public function __construct()
    {
        $this->middleware(['permission:LISTAR'])->only('listar');
        $this->middleware(['permission:CREAR'])->only('store');
        $this->middleware(['permission:EDITAR'])->only('update');
        $this->middleware(['permission:ELIMINAR'])->only('destroy');
        $this->middleware(['permission:VER'])->only('show');
    }

    /**
     * Lista antecedentes de un paciente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $numero_documento Documento de identificacion del paciente
     * @return \Illuminate\Http\Response
     */
    public function listar(Request $request, $numero_documento)
    {
        if ($numero_documento == "") {
            return response()->json([
                'message' => 'Error de Validación',
                'errors'  => "El No Documento del paciente no puede ser vacío."
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
        ])
        ->where('numero_documento', $numero_documento)
        ->first();

        if (!$paciente) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors'  => "El Paciente con No Documento $numero_documento no existe."
            ], 404);
        }

        $antecedente = Antecedente::select([
                'antecedentes.id',
                'id_paciente',
                'antecedentes.numero_antecedente',
                'antecedentes.created_at',
                'antecedentes.updated_at'
            ])
            ->where('id_paciente', $paciente->id)
            ->Buscar($request->buscar)
            ->Ordenamiento($request->orderColumn, $request->order)
            ->with([
                'getPaciente' => function ($query){
                    $query->select([
                        'id',
                        'numero_documento',
                        'nombre',
                        'apellido'
                    ]);
                }
            ]);

        // consulta para saber cuantos registros hay.
        $totalRegistros = $antecedente->count();

        $registros = $antecedente->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'data'      => $registros,
            'filtrados' => $registros->count(),
            'total'     => $totalRegistros,
        ], 200);
    }

    /**
     * Método que guarda antecedente para un paciente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errores = [];
        $validator = Validator::make(
                                    $request->all(),
                                    Antecedente::$rulesStore,
                                    Antecedente::$messages);

        if (!$request->filled('antecedentes') && !$request->filled('otro')) {
            $validator->after(function ($validator) {
                $validator->errors()->add('sin_antecedentes', 'Debe marcar los Antecedentes o ingresar antecedente en el campo Otro si no se encuentra.');
            });
        }

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
                'errors' => "No existe un paciente con el Número de Documento $request->numero_documento."
            ], 409);
        }

        try {
            $numeroAntecedente = $this->obtenerNumeroAntecedente($request->numero_documento);

            $request->merge([
                'id_paciente'               => $paciente->id,
                'numero_antecedente'        => $numeroAntecedente
            ]);
            $input = $request->except(['numero_documento']);
            $input = $request->collect();

            $data = $input->map(function ($valor, $key) {
                if ($key == "otro") {
                    if ($valor != "") {
                        $valor = trim(strtoupper($this->fnEliminarTildes($valor)));
                    }
                }else{
                    $valor = trim($valor);
                }
                return $valor;
            })->all();

            Antecedente::create($data);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error inesperado',
                'errors' => 'Error al Guardar datos.'
            ], 500);
        }

        return response()->json([
            'message' => 'Datos Guardados.',
        ], 201);
    }

    /**
     * Método que muestra un antecedente en especifico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $antecedente = Antecedente::findOrfail($id);

        return response()->json([
            'data'      => $antecedente,
        ], 200);
    }

    /**
     * Actualiza un antecedente.
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
                                    Antecedente::$rulesStore,
                                    Antecedente::$messages);

        if (!$request->filled('antecedentes') && !$request->filled('otro')) {
            $validator->after(function ($validator) {
                $validator->errors()->add('sin_antecedentes', 'Debe marcar los Antecedentes o ingresar antecedente en el campo Otro si no se encuentra.');
            });
        }

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
                'errors' => "No existe un paciente con el Número de Documento $request->numero_documento."
            ], 409);
        }

        $antecedente = Antecedente::select('id')->where('id', $id)->first();
        if (!$antecedente) {
            return response()->json([
                'message' => 'Validación de Datos',
                'errors' => "No existe Antecedente."
            ], 404);
        }

        try {
            $request->merge([
                'id_paciente'               => $paciente->id,
            ]);
            $input = $request->except(['numero_documento']);
            $input = $request->collect();

            $data = $input->map(function ($valor, $key) {
                if ($key == "otro") {
                    if ($valor != "") {
                        $valor = trim(strtoupper($this->fnEliminarTildes($valor)));
                    }
                }else{
                    $valor = trim($valor);
                }
                return $valor;
            })->all();

            $antecedente->update($data);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error inesperado',
                'errors' => 'Error al Guardar datos.'
            ], 500);
        }

        return response()->json([
            'message' => 'Datos Actualizados.',
        ], 201);
    }

    /**
     * Elimina un antecedente temporalmente.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $antecedente = Antecedente::where('id',$id)->first();
        if ($antecedente) {
            try {
                // Eliminando
                $antecedente->delete();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Error inesperado en el Sistema',
                    'errors' => "Error al eliminar Antecedente No.$antecedente->numero_antecedente"
                ], 500);
            }

            return response()->json([
                'message' => "El Antecedente No.$antecedente->numero_antecedente ha sido eliminado.",
            ], 201);
        }else{
            return response()->json([
                'message' => 'Validación de Datos',
                'errors' => "No existe Antecedente que intenta eliminar."
            ], 404);
        }
    }

    /**
     * Método que retorna el consecutivo de Antecedente del paciente.
     *
     * @param integer $numero_documento Numero de documento del paciente.
     * @return string consecutivo antecedente.
     */
    public function obtenerNumeroAntecedente($numero_documento){
        $id_paciente = Paciente::select('id')->where('numero_documento',$numero_documento)->first();
        if (!$id_paciente) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors'  => "El Paciente con No Documento $numero_documento no existe."
            ], 404);
        }
        try {
            $numeroAntecedente = Antecedente::select('numero_antecedente')
                ->where('id_paciente', $id_paciente->id)
                ->orderBy('id', 'desc')
                ->first();

            if(!$numeroAntecedente){
                $numero_antecedente = "0000";
            }else{
                $numero_antecedente = $numeroAntecedente->numero_antecedente;
            }

            $numero_antecedente = intval($numero_antecedente)+1;
            return str_pad(strval($numero_antecedente), 4,"0",STR_PAD_LEFT);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error inesperado en el Sistema',
                'errors' => "Error al obtener Número consecutivo Antecedente."
            ], 500);
        }
    }
}
