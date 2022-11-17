<?php

namespace App\Http\Controllers\HistoriaClinica;

use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Models\FormulaAnteojos;
use App\Http\Controllers\Controller;
use App\Models\Antecedente;
use App\Models\MotivoConsulta;
use App\Traits\metodosComunesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

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
                'errors'  => "El Paciente con No Documento $numero_documento no existe."
            ], 404);
        }

        $historiasClinicas = DB::table('formula_anteojos')
        ->join('paciente', 'formula_anteojos.id_paciente', '=', 'paciente.id')

        ->leftJoin('motivo_consulta', function($query){
            $query->on('formula_anteojos.numero_formula_anteojos', '=', 'motivo_consulta.mc_consecutivo')
                ->on('formula_anteojos.id_paciente', '=', 'motivo_consulta.id_paciente');
        })
        ->leftJoin('antecedentes', function($query){
            $query->on('formula_anteojos.numero_formula_anteojos', '=', 'antecedentes.numero_antecedente')
                ->on('formula_anteojos.id_paciente', '=', 'antecedentes.id_paciente');
        })
        ->where('formula_anteojos.id_paciente', $paciente->id);

        $buscar = $request->buscar;
        // Buscar
        if($buscar){
            $historiasClinicas = $historiasClinicas->where('formula_anteojos.numero_formula_anteojos', 'like', '%'.trim($buscar).'%')
                        ->orWhere('formula_anteojos.fecha_formula', 'like', '%'.trim($buscar).'%')
                        ->orWhere('formula_anteojos.updated_at', 'like', '%'.trim($buscar).'%')
                        ->orWhere('paciente.numero_documento', 'LIKE', "%".trim($buscar)."%")
                        ->orWhere('paciente.nombre', 'LIKE', "%".trim($buscar)."%")
                        ->orWhere('paciente.apellido', 'LIKE', "%".trim($buscar)."%");
        }

        // ordenamiento
        $columna = $request->orderColumn;
        $orden   = $request->order;
        if ($columna != "" && $orden != "") {
            if (strtolower($orden) != "desc" && strtolower($orden) != "asc") {
                $orden = "desc";
            }
            switch ($columna) {
                case 'numero_formula_anteojos':
                case 'fecha_formula':
                case 'updated_at':
                    $historiasClinicas = $historiasClinicas->orderBy("formula_anteojos.".$columna, $orden);
                break;
                case 'numero_documento':
                case 'nombre':
                case 'apellido':
                    $historiasClinicas = $historiasClinicas->orderBy("paciente.".$columna, $orden);
                break;
            }
        }

        // consulta para saber cuantos registros hay.
        $totalRegistros = $historiasClinicas->count();

        if ($totalRegistros == 0) {
            return response()->json([
                'data'      => [
                    $paciente
                ],
                'filtrados' => 0,
                'total'     => 0,
            ], 200);
        }
        $historiasClinicas = $historiasClinicas->select(
            'paciente.nombre',
            'paciente.apellido',
            'paciente.numero_documento',
            'paciente.fecha_nacimiento',
            'paciente.edad',
            'formula_anteojos.id',
            'formula_anteojos.id_paciente',
            'formula_anteojos.numero_formula_anteojos',
            'formula_anteojos.fecha_formula',
            'formula_anteojos.updated_at')
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'data'      => $historiasClinicas,
            'filtrados' => $historiasClinicas->count(),
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
        // ====================== VALIDACIONES FORMULA ANTEOJOS ================
        $validatorFormulaAnteojos = Validator::make($request->all(),FormulaAnteojos::$rulesStore,FormulaAnteojos::$messages);
        if ($validatorFormulaAnteojos->fails()) {
            $errores['erroresFormulaAnteojos'] = $validatorFormulaAnteojos->errors();
        }

        // ======================== VALIDACIONES MOTIVO CONSULTA ==================
        $validatorMotivoConsulta = Validator::make($request->all(),MotivoConsulta::$rulesStore,MotivoConsulta::$messages);
        if ($validatorMotivoConsulta->fails()) {
            $errores['erroresMotivoConsulta'] = $validatorMotivoConsulta->errors();
        }

        if($request->hasFile('refracciones')){
            foreach($request->file('refracciones') as $file){
                $validatorMotivoConsultaRefraccion = Validator::make(["url_refraccion" => $file],['url_refraccion' => 'mimes:jpg,jpeg,png'],MotivoConsulta::$messages);
                if ($validatorMotivoConsultaRefraccion->fails()) {
                    $errores['erroresMotivoConsulta'] = $validatorMotivoConsultaRefraccion->errors();
                }
            }
        }

        // ======================== VALIDACIONES ANTECEDENTES ==================
        $validatorAntecedentes = Validator::make($request->all(),Antecedente::$rulesStore,Antecedente::$messages);

        if (!$request->filled('antecedentes') && !$request->filled('otro')) {
            $validatorAntecedentes->after(function ($validatorAntecedentes) {
                $validatorAntecedentes->errors()->add('sin_antecedentes', 'Debe marcar mimimo un Antecedente o ingresar antecedente en el campo Otro si no se encuentra.');
            });
        }
        if ($validatorAntecedentes->fails()) {
            $errores['erroresAntecedentes'] = $validatorAntecedentes->errors();
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
            // ======= GUARDAR FORMULA ANTEOJOS ==============
            $consecutuvo = $this->obtenerNumeroFormulaAnteojos($request->numero_documento);

            $request->merge([
                'id_paciente'               => $paciente->id,
                'numero_formula_anteojos'   => $consecutuvo
            ]);

            // Campos que no hacen parte de formula anteojos
            $vRequestFormulaAnteojos = $request->except([
                'numero_documento',
                // Motivo consulta
                'refracciones',
                'descripcion_motivo_consulta',
                // antecedentes
                'antecedentes',
                'otro'
            ]);
            foreach ($vRequestFormulaAnteojos as $key => $value) {
                if ($value == null) {
                    $vRequestFormulaAnteojos[$key] = "";
                }

                if ($key == "diagnostico" || $key == "tratamiento" || $key == "observacion" || $key == "orden_medica") {
                    if ($value != "") {
                        $vRequestFormulaAnteojos[$key] = trim(strtoupper($this->fnEliminarTildes($value)));
                    }
                }else if($value != ""){
                    $vRequestFormulaAnteojos[$key] = trim($value);
                }
            }

            FormulaAnteojos::create($vRequestFormulaAnteojos);

            // ======= GUARDAR MOTIVO CONSULTA ==============

            if (!file_exists(public_path('storage/img-refracciones-temporal'))) {
                File::makeDirectory(public_path('storage/img-refracciones-temporal'), 0777);
            }
            if (!file_exists(public_path('storage/refracciones'))) {
                File::makeDirectory(public_path('storage/refracciones'), 0777);
            }

            $nombrePdf = null;

            if($request->hasFile('refracciones')){

                // Procesando imagenes para crear pdf con refracciones subida.
                $vReturnPdfRefracciones = $this->fnPdfRefracciones($request, $consecutuvo);

                if ($vReturnPdfRefracciones[0] == "false") {
                    return response()->json([
                        'message' => 'Error inesperado.',
                        'errors' => "Error al procesar archivos refracciones, por favor comuniquese con el area de Tecnología, Gracias.".$vReturnPdfRefracciones[2]
                    ], 500);
                }else{
                    $nombrePdf = $vReturnPdfRefracciones[1];
                }

            }

            MotivoConsulta::create([
                "id_paciente"       => $paciente->id,
                "mc_consecutivo"  => $consecutuvo,
                "url_refraccion"    => $nombrePdf,
                "descripcion"       => trim(strtoupper($this->fnEliminarTildes($request->descripcion_motivo_consulta)))
            ]);
            // ======= GUARDAR MOTIVO CONSULTA ==============

            // =========== GUARDAR ANTECEDENTES ======================
            Antecedente::create([
                'id_paciente'               => $paciente->id,
                'numero_antecedente'        => $consecutuvo,
                'antecedentes'              => $request->antecedentes,
                'otro'                      => trim(strtoupper($this->fnEliminarTildes($request->otro)))
            ]);
            // =========== GUARDAR ANTECEDENTES ======================
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
        $historiasClinicas = DB::table('formula_anteojos')
        ->join('paciente', 'formula_anteojos.id_paciente', '=', 'paciente.id')

        ->leftJoin('motivo_consulta', function($query){
            $query->on('formula_anteojos.numero_formula_anteojos', '=', 'motivo_consulta.mc_consecutivo')
                ->on('formula_anteojos.id_paciente', '=', 'motivo_consulta.id_paciente');
        })
        ->leftJoin('antecedentes', function($query){
            $query->on('formula_anteojos.numero_formula_anteojos', '=', 'antecedentes.numero_antecedente')
                ->on('formula_anteojos.id_paciente', '=', 'antecedentes.id_paciente');
        })
        ->where('formula_anteojos.id',$id)
        ->select(
            'formula_anteojos.*',
            'motivo_consulta.id as id_motivo_consulta',
            'motivo_consulta.url_refraccion',
            'motivo_consulta.descripcion as descripcion_motivo_consulta',
            'antecedentes.id as id_antecedentes',
            'antecedentes.antecedentes',
            'antecedentes.otro')
        ->first();

        return response()->json([
            'data'      => $historiasClinicas,
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
        //=================== INICIO VALIDACIONES ======================//

        // 1. FORMULA ANTEOJOS
        $validatorFormulaAnteojos = Validator::make($request->all(),FormulaAnteojos::$rulesStore,FormulaAnteojos::$messages);
        if ($validatorFormulaAnteojos->fails()) {
            $errores['erroresFormulaAnteojos'] = $validatorFormulaAnteojos->errors();
        }
        if (count($errores) > 0) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors' => $errores
            ], 422);
        }

        // 2. VALIDANDO MOTIVO CONSULTA

        $validatorMotivoConsulta = Validator::make($request->all(),MotivoConsulta::fnRulesUpdate(),MotivoConsulta::$messages);
        if ($validatorMotivoConsulta->fails()) {
            $errores['erroresMotivoConsulta'] = $validatorMotivoConsulta->errors();
        }

        // Validando refracciones.
        if($request->hasFile('refracciones')){
            foreach($request->file('refracciones') as $file){
                $validatorMotivoConsultaFile = Validator::make(["url_refraccion" => $file],['url_refraccion' => 'mimes:jpg,jpeg,bmp,png'],MotivoConsulta::$messages);
                if ($validatorMotivoConsultaFile->fails()) {
                    $errores['erroresMotivoConsulta'] = $validatorMotivoConsultaFile->errors();
                }
            }
        }

        // 3. VALIDANDO ANTECEDENTES

        $validatorAntecedentes = Validator::make($request->all(),Antecedente::$rulesStore,Antecedente::$messages);

        if (!$request->filled('antecedentes') && !$request->filled('otro')) {
            $validatorAntecedentes->after(function ($validatorAntecedentes) {
                $validatorAntecedentes->errors()->add('sin_antecedentes', 'Debe marcar los Antecedentes o ingresar antecedente en el campo Otro si no se encuentra.');
            });
        }

        if ($validatorAntecedentes->fails()) {
            $errores['erroresAntecedentes'] = $validatorAntecedentes->errors();
        }

        // ================== FIN VALIDACIONES ======================//

        if (count($errores) > 0) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors' => $errores
            ], 422);
        }

        // ====== UPDATE ==========//

        // consultando que exista el paciente
        $paciente = Paciente::select('id')->where('numero_documento', $request->numero_documento)->first();
        if (!$paciente) {
            return response()->json([
                'message' => 'Validación de Datos',
                'errors' => "No existe un paciente con el Número de Documento $request->numero_documento."
            ], 409);
        }

        $formulaAnteojos = FormulaAnteojos::where('id', $id)->first();
        if (!$formulaAnteojos) {
            return response()->json([
                'message' => 'Validación de Datos',
                'errors' => "No existe formula de anteojos."
            ], 404);
        }

        // 1. FORMULA ANTEOJOS
        // Campos que no hacen parte de formula anteojos
        $vRequestFormulaAnteojos = $request->except([
            'id',
            'numero_documento',
            // Motivo consulta
            'id_motivo_consulta',
            'refracciones',
            'descripcion_motivo_consulta',
            // antecedentes
            'id_antecedentes',
            'antecedentes',
            'otro'
        ]);
        foreach ($vRequestFormulaAnteojos as $key => $value) {
            if ($value == null) {
                $vRequestFormulaAnteojos[$key] = "";
            }

            if ($key == "diagnostico" || $key == "tratamiento" || $key == "observaciones2" || $key == "orden_medica") {
                if ($value != "") {
                    $vRequestFormulaAnteojos[$key] = trim(strtoupper($this->fnEliminarTildes($value)));
                }
            }else if($value != ""){
                $vRequestFormulaAnteojos[$key] = trim($value);
            }
        }

        // 2. MOTIVO CONSULTA
        $motivo_consulta = MotivoConsulta::where('id',$request->id_motivo_consulta)->first();
        $nombrePdf = null; // Variable para guardar el nombre del archivo PDF.
        if ($motivo_consulta) {

            // Determina si el parametro está ausente.
            if ($request->missing('refracciones')) {
                $nombrePdf = $motivo_consulta->url_refraccion;
            }else{

                if($request->hasFile('refracciones')){

                    // Eliminando PDF, porque se subieron refracciones nuevas.
                    File::delete(public_path('storage/refracciones/').$motivo_consulta->url_refraccion);

                    // Procesando imagenes para crear pdf con refracciones subida.
                    $vReturnPdfRefracciones = $this->fnPdfRefracciones($request, $motivo_consulta->mc_consecutivo);

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
                        File::delete(public_path('storage/refracciones/').$motivo_consulta->url_refraccion);
                    } catch (Exception $e) {
                        return response()->json([
                            'message' => 'Error inesperado',
                            'errors' => [
                                'Error al eliminar PDF refracciones.'
                            ]
                        ], 500);
                    }
                }
            }
        }else{
            if($request->hasFile('refracciones')){

                // Procesando imagenes para crear pdf con refracciones subida.
                $vReturnPdfRefracciones = $this->fnPdfRefracciones($request, $formulaAnteojos->numero_formula_anteojos);

                if ($vReturnPdfRefracciones[0] == "false") {
                    return response()->json([
                        'message' => 'Error inesperado.',
                        'errors' => "Error al procesar archivos refracciones, por favor comuniquese con el area de Tecnología, Gracias.".$vReturnPdfRefracciones[2]
                    ], 500);
                }else{
                    $nombrePdf = $vReturnPdfRefracciones[1];
                }
            }
        }

        try {
            // FORMULA ANTEOJOS
            FormulaAnteojos::find($id)->update($vRequestFormulaAnteojos);

            // MOTIVO CONSULTA
            if (!$motivo_consulta) {
                // Crear motivo consulta.
                MotivoConsulta::create([
                    "id_paciente"       => $paciente->id,
                    "mc_consecutivo"  => $formulaAnteojos->numero_formula_anteojos,
                    "url_refraccion"    => $nombrePdf,
                    "descripcion"       => trim(strtoupper($this->fnEliminarTildes($request->descripcion_motivo_consulta)))
                ]);
            }else{
                // Actualizar motivo consulta.
                $motivo_consulta->update([
                    "descripcion"    => trim(strtoupper($this->fnEliminarTildes($request->descripcion_motivo_consulta))),
                    "url_refraccion" => $nombrePdf,
                ]);
            }

            // ANTECEDENTES
            $antecedente = Antecedente::select('id')->where('id', $request->id_antecedentes)->first();
            if (!$antecedente) {
                // Crear antecedentes.
                Antecedente::create([
                    'id_paciente'               => $paciente->id,
                    'numero_antecedente'        => $formulaAnteojos->numero_formula_anteojos,
                    'antecedentes'              => $request->antecedentes,
                    'otro'                      => trim(strtoupper($this->fnEliminarTildes($request->otro)))
                ]);
            }else{
                // Actualizar antecedentes.
                Antecedente::find($request->id_antecedentes)->update([
                    'antecedentes' => $request->antecedentes,
                    'otro'         => trim(strtoupper($this->fnEliminarTildes($request->otro))),
                ]);
            }


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
                $antecedente = Antecedente::select('id')->where(
                    [
                        ['numero_antecedente', '=', $formulaAnteojos->numero_formula_anteojos],
                        ['id_paciente'       , '=', $formulaAnteojos->id_paciente]
                    ]
                    )->first();
                if (!$antecedente) {
                    return response()->json([
                        'message' => 'Error inesperado',
                        'errors' => "No existe Antecedente."
                    ], 404);
                }

                $motivo_consulta = MotivoConsulta::select('id')->where(
                    [
                        ['mc_consecutivo', '=', $formulaAnteojos->numero_formula_anteojos],
                        ['id_paciente'       , '=', $formulaAnteojos->id_paciente]
                    ]
                    )->first();
                if (!$motivo_consulta) {
                    return response()->json([
                        'message' => 'Error inesperado',
                        'errors' => "No existe Motivo consulta."
                    ], 404);
                }

                if ($antecedente && $motivo_consulta) {
                    FormulaAnteojos::find($formulaAnteojos->id)->forceDelete();
                    Antecedente::find($antecedente->id)->forceDelete();
                    MotivoConsulta::find($motivo_consulta->id)->delete(); // este modelo no tiene SoftDeletes
                }

            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Error inesperado en el Sistema',
                    'errors' => "Error al eliminar Historia Clinica No.$formulaAnteojos->numero_formula_anteojos"
                ], 500);
            }

            return response()->json([
                'message' => "La Historia Clinica No.$formulaAnteojos->numero_formula_anteojos ha sido eliminada.",
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
     * Método que genera reporte en PDF de Historia clinica.
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
                $mData['mostrar_info_centro'] = "";
                $data = [
                    "tratamiento"       => $formulaAnteojos->tratamiento,
                    "pacienteCc"        => $paciente->numero_documento,
                    "nombrePaciente"    => $paciente->nombre." ".$paciente->apellido
                ];
                $mData['data'] = $data;
            break;
            case 'orden_medica':
                $mData['tipo_rerporte']       = 'orden_medica';
                $mData['mostrar_info_centro'] = $request->mostrar_info_centro;
                $data = [
                    "orden_medica"      => $formulaAnteojos->orden_medica,
                    "pacienteCc"        => $paciente->numero_documento,
                    "nombrePaciente"    => $paciente->nombre." ".$paciente->apellido
                ];
                $mData['data'] = $data;
            break;
            case 'rx':
                $mData['tipo_rerporte'] = 'rx';
                $mData['mostrar_info_centro'] = "";
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
