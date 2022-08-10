<?php

namespace App\Http\Controllers\HistoriaClinica;

use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Models\FormulaAnteojos;
use App\Http\Controllers\Controller;
use App\Traits\metodosComunesTrait;
use Illuminate\Support\Facades\Validator;

class FormulaAnteojosController extends Controller
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
     * Muestra historial clinico formula anteojos de paciente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $numero_documento Documento de identificacion del paciente
     * @return \Illuminate\Http\Response
     */
    public function listar(Request $request, $numero_documento){

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

        $formulaAnteojos = FormulaAnteojos::select([
                'formula_anteojos.id',
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
            $numeroFormulaAnteojos = $this->obtenerNumeroFormulaAnteojos($request->numero_documento);

            $request->merge([
                'id_paciente'               => $paciente->id,
                'numero_formula_anteojos'   => $numeroFormulaAnteojos
            ]);
            $input = $request->except(['numero_documento']);
            $input = $request->collect();

            $data = $input->map(function ($valor, $key) {
                if ($key == "diagnostico" || $key == "tratamiento" || $key == "observacion" || $key == "orden_medica") {
                    if ($valor != "") {
                        $valor = trim(strtoupper($this->fnEliminarTildes($valor)));
                    }
                }else if($valor != ""){
                    $valor = trim($valor);
                }
                return $valor;
            })->all();

            FormulaAnteojos::create($data);
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
                'errors' => "No existe formula de anteojos."
            ], 404);
        }

        try {

            $input = $request->except(['numero_documento']);
            $input = $request->collect();

            $data = $input->map(function ($valor, $key) {
                if ($key == "diagnostico" || $key == "tratamiento" || $key == "observacion" || $key == "orden_medica") {
                    if ($valor != "") {
                        $valor = trim(strtoupper($this->fnEliminarTildes($valor)));
                    }
                }else{
                    $valor = trim($valor);
                }
                return $valor;
            })->all();
            $formulaAnteojos->update($data);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error inesperado',
                'errors' => [
                    'Error al Actualizar datos.'.$e
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
                'errors' => "No existe formula de anteojos."
            ], 404);
        }
    }

    /**
     * Método que retorna el consecutivo de numero formula anteojos para la historia clinica del paciente.
     *
     * @param integer $numero_documento Numero de documento del paciente.
     * @return string consecutivo Historia clinica Formula anteojos.
     */
    public function obtenerNumeroFormulaAnteojos($numero_documento){
        $id_paciente = Paciente::select('id')->where('numero_documento',$numero_documento)->first();
        if (!$id_paciente) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors'  => "El Paciente con No Documento $numero_documento no existe."
            ], 404);
        }
        try {
            $numeroFormulaAnteojos = FormulaAnteojos::select('numero_formula_anteojos')
                ->where('id_paciente', $id_paciente->id)
                ->orderBy('id', 'desc')
                ->first();

            if(!$numeroFormulaAnteojos){
                $numero_formula_anteojos = "0000";
            }else{
                $numero_formula_anteojos = $numeroFormulaAnteojos->numero_formula_anteojos;
            }

            $numero_formula_anteojos = intval($numero_formula_anteojos)+1;
            return str_pad(strval($numero_formula_anteojos), 4,"0",STR_PAD_LEFT);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error inesperado en el Sistema',
                'errors' => "Error al obtener Número formula anteojos consecutivo."
            ], 500);
        }
    }

    /**
     * Método que genera reporte en PDF de Formula Anteojos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reportePdf(Request $request){
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

        $formulaAnteojos = FormulaAnteojos::findOrFail($request->id_formula);

        switch ($request->tipo_reporte) {
            case 'formula':
                $mData['tipo_rerporte'] = 'formula';
                $data = [
                    "tratamiento"       => $formulaAnteojos->tratamiento,
                    "pacienteCc"        => $paciente->numero_documento,
                    "nombrePaciente"    => $paciente->nombre." ".$paciente->apellido
                ];
                $mData['data'] = $data;
            break;
            case 'orden_medica':
                $mData['tipo_rerporte'] = 'orden_medica';
                $data = [
                    "orden_medica"      => $formulaAnteojos->orden_medica,
                    "pacienteCc"        => $paciente->numero_documento,
                    "nombrePaciente"    => $paciente->nombre." ".$paciente->apellido
                ];
                $mData['data'] = $data;
            break;
            case 'rx':
                $mData['tipo_rerporte'] = 'rx';
                $data = [
                    "pacienteCc"        => $paciente->numero_documento,
                    "nombrePaciente"    => $paciente->nombre." ".$paciente->apellido,
                    "rx_od"             => $formulaAnteojos->rx_od,
                    "rx_oi"             => $formulaAnteojos->rx_oi,
                    "adicion"           => $formulaAnteojos->adicion,
                    "dp"                => $formulaAnteojos->dp,
                    "observacion"       => $formulaAnteojos->observacion
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
