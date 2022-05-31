<?php

namespace App\Http\Controllers\HistoriaClinica;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Resources\FormulaAnteojosListarCollection;
use App\Models\FormulaAnteojos;
use App\Models\Paciente;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FormulaAnteojosController extends Controller
{

    /**
     * Muestra historial clinico formula anteojos de paciente.
     *
     * @return \Illuminate\Http\Response
     */
    public function listar(Request $request){

        if (!$request->filled('numero_documento')) {
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
        ->where('numero_documento', $request->numero_documento)
        ->first();

        if (!$paciente) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors'  => "El Paciente con No Documento $request->numero_documento no existe."
            ], 404);
        }

        $formulaAnteojos = FormulaAnteojos::select([
                'id_paciente',
                'numero_formula_anteojos',
                'fecha_formula',
                'formula_anteojos.updated_at'
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
        $totalRegistros = $formulaAnteojos->count();

        $registros = $formulaAnteojos->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'data'      => $registros,
            'filtrados' => $registros->count(),
            'total'     => $totalRegistros,
        ], 200);
    }

    /**
     * Guarda formula de anteojos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errores = [];
        $validator = Validator::make(
                                    $request->all(),
                                    FormulaAnteojos::$rulesStore,
                                    FormulaAnteojos::$messages);
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
            $numeroFormulaAnteojos = $this->obtenerNumeroFormulaAnteojos($paciente->id);

            $request->merge([
                'id_paciente'               => $paciente->id,
                'numero_formula_anteojos'   => $numeroFormulaAnteojos
            ]);

            $input = $request->except(['numero_documento']);

            FormulaAnteojos::create($input);
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
     * Muestra una formula anteojos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $formulaAnteojos = FormulaAnteojos::findOrfail($id);

        return response()->json([
            'data'      => $formulaAnteojos,
        ], 200);
    }

    /**
     * Actualiza una formula anteojos de un paciente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id id formula anteojos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $errores = [];
        $validator = Validator::make(
                                    $request->all(),
                                    FormulaAnteojos::$rulesStore,
                                    FormulaAnteojos::$messages);
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

        $formulaAnteojos = FormulaAnteojos::select('id')->where('id', $id)->first();
        if (!$formulaAnteojos) {
            return response()->json([
                'message' => 'Validación de Datos',
                'errors' => "No existeste formula de anteojos."
            ], 404);
        }

        try {
            $numeroFormulaAnteojos = $this->obtenerNumeroFormulaAnteojos($paciente->id);

            $request->merge([
                'numero_formula_anteojos'   => $numeroFormulaAnteojos
            ]);

            $input = $request->except(['numero_documento']);

            $formulaAnteojos->update($input);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error inesperado',
                'errors' => [
                    'Error al Actualizar datos.'
                ]
            ], 500);
        }

        return response()->json([
            'message' => 'Datos Actualizados.',
        ], 201);

    }

    /**
     * Elimina formula anteojos con SoftDeletes.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $formulaAnteojos = FormulaAnteojos::where('id',$id)->first();
        if ($formulaAnteojos) {
            try {
                // Eliminando
                $formulaAnteojos->delete();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Error inesperado en el Sistema',
                    'errors' => "Error al eliminar Formula Anteojos No.$formulaAnteojos->numero_formula_anteojos"
                ], 500);
            }

            return response()->json([
                'message' => "La Formula Anteojos No.$formulaAnteojos->numero_formula_anteojos ha sido eliminada.",
            ], 201);
        }else{
            return response()->json([
                'message' => 'Validación de Datos',
                'errors' => "No existeste formula de anteojos."
            ], 404);
        }
    }

    /**
     * Método que retorna el consecutivo de numero formula anteojos para la historia clinica del paciente.
     *
     * @param integer $id_paciente
     * @return string consecutivo Historia clinica Formula anteojos.
     */
    public function obtenerNumeroFormulaAnteojos($id_paciente){
        $numeroFormulaAnteojos = FormulaAnteojos::select('numero_formula_anteojos')
            ->where('id_paciente', $id_paciente)
            ->orderBy('id', 'desc')
            ->first();

        if(!$numeroFormulaAnteojos){
            $numero_formula_anteojos = "0000";
        }else{
            $numero_formula_anteojos = $numeroFormulaAnteojos->numero_formula_anteojos;
        }

        $numero_formula_anteojos = intval($numero_formula_anteojos)+1;
        return str_pad(strval($numero_formula_anteojos), 4,"0",STR_PAD_LEFT);
    }
}
