<?php

namespace App\Http\Controllers\Paciente;

use Exception;
use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Traits\metodosComunesTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PacienteController extends Controller
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
        $registros = Paciente::Buscar($request->buscar)
            ->Ordenamiento($request->orderColumn, $request->order);

        // consulta para saber cuantos registros hay.
        $totalRegistros = $registros->count();

        $registros = $registros->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'data'      => $registros,
            'filtrados' => $registros->count(),
            'total'     => $totalRegistros,
        ], 200);
    }

    /**
     * Crear paciente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $errores = [];
        $validator = Validator::make(
                                    $request->all(),
                                    Paciente::$rulesStore,
                                    Paciente::$messages);
        if ($validator->fails()) {
            $errores = $validator->errors();
        }

        if (count($errores) > 0) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors'  => $errores
            ], 422);
        }

        try {
            $urlFotoGuardada = $this->guardarArchivoSubido($request, "foto", "fotos-paciente");

            $input = $request->collect();

            $data = $input->map(function ($valor, $key) {
                if ($key == "nombre" || $key == "apellido") {
                    if ($valor != "") {
                        $valor = trim(strtoupper($this->fnEliminarTildes($valor)));
                    }
                }else if($valor == null){
                    $valor = "";
                }else if($valor != ""){
                    $valor = trim(strtoupper($valor));
                }

                // Si no se envia valor en fecha nacimiento se deja null
                if ($key == "fecha_nacimiento" && $valor == "") {
                    $valor = null;
                }
                return $valor;
            })->all();

            $data['foto']           = $urlFotoGuardada;
            $data['fecha_creacion'] = trim($request->fecha_creacion." ".date('H:i:s'));

            // Guardando datos
            Paciente::create($data);
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
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paciente = Paciente::findOrfail($id);

        $paciente->fecha_creacion    = substr($paciente->fecha_creacion,0,10);
        if ($paciente->fecha_nacimiento != "") {
            $paciente->fecha_nacimiento  = substr($paciente->fecha_nacimiento,0,10);
        }

        return response()->json([
            'data'      => $paciente,
        ], 200);
    }

    /**
     * Actualiza un paciente
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $paciente = Paciente::findOrfail($id);

        $errores = [];
        $validator = Validator::make(
                                    $request->all(),
                                    Paciente::fnRulesUpdate($paciente),
                                    Paciente::$messages);
        if ($validator->fails()) {
            $errores = $validator->errors();
        }

        if (count($errores) > 0) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors'  => $errores
            ], 422);
        }

        if ($paciente) {
            if ($paciente->foto != $request->foto) {
                if($request->foto != "" && $request->foto != null){
                    $urlFoto = $this->guardarArchivoSubido($request, "foto", "fotos-paciente");
                }else{
                    if (file_exists(public_path($paciente->foto))) {
                        // eliminando si existe archivo y si no se envia ninguna imagen.
                        unlink(public_path($paciente->foto));
                    }
                    $urlFoto = "";
                }
            }else{
                $urlFoto = $paciente->foto;
            }

            try {
                $paciente->update([
                    'tipo_documento'    => trim(strtoupper($request->tipo_documento)),
                    'numero_documento'  => trim(strtoupper($request->numero_documento)),
                    'nombre'            => trim(strtoupper($request->nombre)),
                    'apellido'          => trim(strtoupper($request->apellido)),
                    'correo'            => trim(strtolower($request->correo)),
                    'celular'           => trim($request->celular),
                    'direccion'         => trim(strtoupper($this->fnEliminarTildes($request->direccion))),
                    'departamento'      => trim(strtoupper($this->fnEliminarTildes($request->departamento))),
                    'municipio'         => trim(strtoupper($this->fnEliminarTildes($request->municipio))),
                    'fecha_nacimiento'  => trim($request->fecha_nacimiento) != "" && trim($request->fecha_nacimiento) != null ? trim($request->fecha_nacimiento) : null,
                    'edad'              => trim($request->edad),
                    'ocupacion'         => trim(strtoupper($request->ocupacion)),
                    'foto'              => $urlFoto,
                    'id_p_eps'          => $request->id_p_eps,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Error en el Sistema',
                    'errors'  => "Error al actualizar paciente, por favor comuniquese con el area de Tecnología, Gracias.".$e
                ], 500);
            }
        }

        return response()->json([
            'message' => "Datos Actualizados con exito.",
        ], 201);
    }

    /**
     * Método que elimina un paciente.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paciente = Paciente::find($id);
        if ($paciente) {
            try {
                // Eliminando
                $paciente->delete();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Error inesperado en el Sistema',
                    'errors' => "Error al eliminar Paciente C.C $paciente->numero_documento"
                ], 500);
            }

            return response()->json([
                'message' => "El Paciente con C.C $paciente->numero_documento ha sido eliminado.",
            ], 201);
        }else{
            return response()->json([
                'message' => 'Validación de Datos',
                'errors' => "No existe el paciente que intenta eliminar."
            ], 404);
        }
    }
}
