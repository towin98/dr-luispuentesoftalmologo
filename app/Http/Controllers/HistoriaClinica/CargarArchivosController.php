<?php

namespace App\Http\Controllers\HistoriaClinica;

use Exception;
use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Models\CargarArchivo;
use App\Traits\metodosComunesTrait;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CargarArchivosController extends Controller
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
     * Lista de archivos archivos cargados de un paciente.
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
            'numero_documento',
            'nombre',
            'apellido',
        ])
        ->where('numero_documento', $numero_documento)
        ->first();

        if (!$paciente) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors'  => "El Paciente con No Documento $numero_documento no existe."
            ], 404);
        }

        $cargarArchivo = CargarArchivo::select([
                'cargar_archivos.id',
                'id_paciente',
                'cargar_archivos.ruta_archivo',
                'cargar_archivos.observacion',
                'cargar_archivos.consecutivo_archivo',
                'cargar_archivos.created_at',
                'cargar_archivos.updated_at'
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
        $totalRegistros = $cargarArchivo->count();

        if ($totalRegistros == 0) {
            return response()->json([
                'data'      => [
                    ["get_paciente" => $paciente]
                ],
                'filtrados' => 0,
                'total'     => 0,
            ], 200);
        }

        $registros = $cargarArchivo->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'data'      => $registros,
            'filtrados' => $registros->count(),
            'total'     => $totalRegistros,
        ], 200);
    }

    /**
     * Método que sube carga al sistema archivo para un paciente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errores = [];
        $validator = Validator::make(
                                    $request->all(),
                                    CargarArchivo::$rulesStore,
                                    CargarArchivo::$messages);

        if ($request->hasFile('ruta_archivo')) {
            $file = $request->file('ruta_archivo');
            if (strlen($file->getClientOriginalName()) > 30) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('ruta_archivo', 'El nombre del archivo es demasiado largo, 30 carácteres máximo, renombrarlo.');
                });
            }
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
            $this->fnCheckDirectoryPublic('storage/historia_clinica');
            $this->fnCheckDirectoryPublic('storage/historia_clinica/carga_archivos');

            $urlArchivoCargado = $this->guardarArchivoSubido($request, "ruta_archivo", "storage/historia_clinica/carga_archivos");
            $numeroConsecutivo = $this->obtenerConsecutivo($request->numero_documento);

            $request->merge([
                'id_paciente'                => $paciente->id,
                'ruta_archivo'               => $urlArchivoCargado,
                'consecutivo_archivo'        => $numeroConsecutivo
            ]);
            $input = $request->except(['numero_documento']);
            $input = $request->collect();

            $data = $input->map(function ($valor, $key) {
                if ($key == "observacion") {
                    if ($valor != "") {
                        $valor = trim(strtoupper($this->fnEliminarTildes($valor)));
                    }
                }else{
                    $valor = trim($valor);
                }
                return $valor;
            })->all();

            CargarArchivo::create($data);
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
     * Método que muestra info de la carga de un archivo en especifico de un paciente.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $archivo = CargarArchivo::findOrfail($id);

        return response()->json([
            'data'      => $archivo,
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
                                    CargarArchivo::$rulesUpdate,
                                    CargarArchivo::$messages);

        if ($request->hasFile('ruta_archivo')) {
            $file = $request->file('ruta_archivo');
            if (strlen($file->getClientOriginalName()) > 30) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('ruta_archivo', 'El nombre del archivo es demasiado largo, 30 carácteres máximo, renombrarlo.');
                });
            }
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

        $archivo = CargarArchivo::select(['id', 'ruta_archivo'])->where('id', $id)->first();
        if (!$archivo) {
            return response()->json([
                'message' => 'Validación de Datos',
                'errors' => "No existe el archivo con los datos especificados."
            ], 404);
        }

        try {
            $this->fnCheckDirectoryPublic('storage/historia_clinica');
            $this->fnCheckDirectoryPublic('storage/historia_clinica/carga_archivos');

            $urlArchivoCargado = $archivo->ruta_archivo;
            // Si se ha cargado un archivo.
            if($request->hasFile('ruta_archivo') || $urlArchivoCargado != $request->ruta_archivo){

                $validator = Validator::make(
                    [
                        "ruta_archivo" => $request->ruta_archivo
                    ],
                    [
                        'ruta_archivo' => 'required|mimes:pdf'
                    ],
                    CargarArchivo::$messages);

                if ($validator->fails()) {
                    $errores = $validator->errors();
                }

                if (count($errores) > 0) {
                    return response()->json([
                        'message' => 'Error de Validación de Datos',
                        'errors' => $errores
                    ], 422);
                }

                // Eliminando PDF, porque se envio nuevo archivo.
                File::delete(public_path($archivo->ruta_archivo));

                // subiendo PDF NUEVO.
                $urlArchivoCargado = $this->guardarArchivoSubido($request, "ruta_archivo", "storage/historia_clinica/carga_archivos");
            }

            $request->merge([
                'ruta_archivo' => $urlArchivoCargado
            ]);
            $input = $request->except(['numero_documento']);
            $input = $request->collect();

            $data = $input->map(function ($valor, $key) {
                if ($key == "observacion") {
                    if ($valor != "") {
                        $valor = trim(strtoupper($this->fnEliminarTildes($valor)));
                    }
                }else{
                    $valor = trim($valor);
                }
                return $valor;
            })->all();

            CargarArchivo::find($id)->update($data);
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
     * Elimina carga de un archivo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $archivoCargado = CargarArchivo::where('id',$id)->first();
        if ($archivoCargado) {
            try {
                // Eliminando Arcivo PDF cargado.
                File::delete(public_path($archivoCargado->ruta_archivo));
                // Eliminando Registro
                $archivoCargado->delete();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Error inesperado en el Sistema',
                    'errors' => "Error al eliminar Archivo Cargado No.$archivoCargado->consecutivo_archivo"
                ], 500);
            }

            return response()->json([
                'message' => "El Archivo Cargado No.$archivoCargado->consecutivo_archivo ha sido eliminado.",
            ], 201);
        }else{
            return response()->json([
                'message' => 'Validación de Datos',
                'errors' => "No existe Archivo Cargado que intenta eliminar."
            ], 404);
        }
    }

    /**
     * Método que retorna el consecutivo de Archivo cargado.
     *
     * @param integer $numero_documento Numero de documento del paciente.
     * @return string consecutivo.
     */
    public function obtenerConsecutivo($numero_documento){
        $id_paciente = Paciente::select('id')->where('numero_documento',$numero_documento)->first();
        if (!$id_paciente) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors'  => "El Paciente con No Documento $numero_documento no existe."
            ], 404);
        }
        try {
            $numeroConsecutivoArchivo = CargarArchivo::select('consecutivo_archivo')
                ->where('id_paciente', $id_paciente->id)
                ->orderBy('id', 'desc')
                ->first();

            if(!$numeroConsecutivoArchivo){
                $consecutivo_archivo = "0000";
            }else{
                $consecutivo_archivo = $numeroConsecutivoArchivo->consecutivo_archivo;
            }

            $consecutivo_archivo = intval($consecutivo_archivo)+1;
            return str_pad(strval($consecutivo_archivo), 4,"0",STR_PAD_LEFT);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error inesperado en el Sistema',
                'errors' => "Error al obtener Consecutivo para el archivo a cargar."
            ], 500);
        }
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
}
