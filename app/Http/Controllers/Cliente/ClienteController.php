<?php

namespace App\Http\Controllers\Cliente;

use Throwable;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Traits\metodosComunesTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    use metodosComunesTrait;
    /**
     * Método que lista todos los registros.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function listar(Request $request, $tipo_cliente)
    {

        // Se válida si envian los parámetros length y start.
        if ($request->has(['length', 'start'])) {
            $length = $request->length;
            $start  = $request->start;
        } else {
            $length = 15;
            $start  = 0;
        }

        switch ($tipo_cliente) {
            case 'persona-juridica':
                $registros = Cliente::where('tipo_cliente', 'persona_juridica')
                    ->BuscarPersonaJuridica($request->buscar);
                break;
            case 'persona-natural':
                $registros = Cliente::where('tipo_cliente', 'persona_natural')
                    ->BuscarPersonaNatural($request->buscar);
                break;
            default:
                return response()->json([
                    'message' => 'Error de Validación de Datos',
                    'errors'  => [
                        "El tipo de cliente enviado no ha sido encontrado en el sistema, verifique."
                    ]
                ], 422);
                break;
        }

        $registros = $registros->Ordenamiento($request->orderColumn, $request->order);

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
     * Crear cliente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->filled('tipo_cliente')) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errores' => [
                    'El sistema requiere el parámetro tipo de cliente, verifíque.'
                ]
            ], 409);
        }

        $errores = [];
        $validator = Validator::make(
                                    $request->all(),
                                    $request->tipo_cliente == 'persona_juridica' ? Cliente::$rulesStorePersonaJuridica : Cliente::$rulesStorePersonaNatural,
                                    Cliente::$messages);
        if ($validator->fails()) {
            $errores = $validator->errors();
        }

        if (count($errores) > 0) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errores' => $errores
            ], 422);
        }

        try {
            if ($request->tipo_cliente == 'persona_juridica') {
                Cliente::create([
                    'tipo_documento'    => trim(strtoupper($request->tipo_documento)),
                    'numero_documento'  => trim(strtoupper($request->numero_documento)),
                    'nombre'            => trim(strtoupper($request->nombre)),
                    'apellido'          => trim(strtoupper($request->apellido)),
                    'tipo_cliente'      => 'persona_juridica',
                    'razon_social'      => trim(strtoupper($request->razon_social)),
                    'nit'               => trim(strtoupper($request->nit)),
                    'correo'            => trim(strtolower($request->correo)),
                    'celular'           => trim($request->celular),
                    'direccion'         => trim(strtoupper($request->direccion)),
                    'departamento'      => trim(strtoupper($request->departamento)),
                    'municipio'         => trim(strtoupper($request->municipio)),
                    'fecha_creacion'    => trim($request->fecha_creacion." ".date('H:i:s'))
                ]);
            }else{
                $urlFotoGuardada = $this->guardarArchivoSubido($request, "foto", "fotos-persona-natural");

                // Guardados datos para persona natural
                Cliente::create([
                    'tipo_documento'    => trim(strtoupper($request->tipo_documento)),
                    'numero_documento'  => trim(strtoupper($request->numero_documento)),
                    'nombre'            => trim(strtoupper($request->nombre)),
                    'apellido'          => trim(strtoupper($request->apellido)),
                    'tipo_cliente'      => 'persona_natural',
                    'razon_social'      => trim(strtoupper($request->razon_social)),
                    'nit'               => trim(strtoupper($request->nit)),
                    'correo'            => trim(strtolower($request->correo)),
                    'celular'           => trim($request->celular),
                    'direccion'         => trim(strtoupper($request->direccion)),
                    'departamento'      => trim(strtoupper($request->departamento)),
                    'municipio'         => trim(strtoupper($request->municipio)),
                    'fecha_nacimiento'  => trim($request->fecha_nacimiento),
                    'edad'              => trim($request->edad),
                    'id_p_ocupacion'    => trim(strtoupper($request->id_p_ocupacion)),
                    'foto'              => $urlFotoGuardada,
                    'id_p_eps'          => $request->id_p_eps,
                    'fecha_creacion'    => trim($request->fecha_creacion." ".date('H:i:s'))
                ]);
            }
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Error inesperado',
                'errores' => [
                    'Error al Guardar datos.'.$e
                ]
            ], 500);
        }

        return response()->json([
            'message' => 'Datos Guardados.',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::findOrfail($id);

        $cliente->fecha_creacion    = substr($cliente->fecha_creacion,0,10);
        if ($cliente->fecha_nacimiento != "") {
            $cliente->fecha_nacimiento  = substr($cliente->fecha_nacimiento,0,10);
        }

        return response()->json([
            'data'      => $cliente,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$request->filled('tipo_cliente')) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errores' => [
                    'El sistema requiere el parámetro tipo de cliente, verifíque.'.$request."pk"
                ]
            ], 409);
        }

        $cliente = Cliente::findOrfail($id);

        $errores = [];
        $validator = Validator::make(
                                    $request->all(),
                                    $request->tipo_cliente == 'persona_juridica' ? Cliente::fnRulesUpdatePersonaJuridica($cliente) : Cliente::fnRulesUpdatePersonaNatural($cliente),
                                    Cliente::$messages);
        if ($validator->fails()) {
            $errores = $validator->errors();
        }

        if (count($errores) > 0) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errores' => $errores
            ], 422);
        }

        if ($cliente) {
            if ($request->tipo_cliente == 'persona_juridica') {

                try {
                    $cliente->update([
                        'tipo_documento'    => trim(strtoupper($request->tipo_documento)),
                        'numero_documento'  => trim(strtoupper($request->numero_documento)),
                        'nombre'            => trim(strtoupper($request->nombre)),
                        'apellido'          => trim(strtoupper($request->apellido)),
                        'tipo_cliente'      => 'persona_juridica',
                        'razon_social'      => trim(strtoupper($request->razon_social)),
                        'nit'               => trim(strtoupper($request->nit)),
                        'correo'            => trim(strtolower($request->correo)),
                        'celular'           => trim($request->celular),
                        'direccion'         => trim(strtoupper($this->fnEliminarTildes($request->direccion))),
                        'departamento'      => trim(strtoupper($this->fnEliminarTildes($request->departamento))),
                        'municipio'         => trim(strtoupper($this->fnEliminarTildes($request->municipio))),
                        'fecha_creacion'    => trim($request->fecha_creacion." ".date('H:i:s'))
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'Error en el Sistema',
                        'errors'  => [
                            "Error al actualizar Cliente Persona Juridica, por favor comuniquese con el area de Tecnología de Sajona, Gracias"
                        ]
                    ], 500);
                }

            }else{

                if ($cliente->foto != $request->foto) {
                    if($request->foto != "" && $request->foto != null){
                        $urlFoto = $this->guardarArchivoSubido($request, "foto", "fotos-persona-natural");
                    }else{
                        if (file_exists(public_path($cliente->foto))) {
                            // eliminando si existe archivo y si no se envia ninguna imagen.
                            unlink(public_path($cliente->foto));
                        }
                        $urlFoto = "";
                    }
                }else{
                    $urlFoto = $cliente->foto;
                }

                try {
                    $cliente->update([
                        'tipo_documento'    => trim(strtoupper($request->tipo_documento)),
                        'numero_documento'  => trim(strtoupper($request->numero_documento)),
                        'nombre'            => trim(strtoupper($request->nombre)),
                        'apellido'          => trim(strtoupper($request->apellido)),
                        'tipo_cliente'      => 'persona_natural',
                        'razon_social'      => trim(strtoupper($request->razon_social)),
                        'nit'               => trim(strtoupper($request->nit)),
                        'correo'            => trim(strtolower($request->correo)),
                        'celular'           => trim($request->celular),
                        'departamento'      => trim(strtoupper($this->fnEliminarTildes($request->departamento))),
                        'municipio'         => trim(strtoupper($this->fnEliminarTildes($request->municipio))),
                        'municipio'         => trim(strtoupper($request->municipio)),
                        'fecha_nacimiento'  => trim($request->fecha_nacimiento),
                        'edad'              => trim($request->edad),
                        'id_p_ocupacion'    => trim(strtoupper($request->id_p_ocupacion)),
                        'foto'              => $urlFoto,
                        'id_p_eps'          => $request->id_p_eps,
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'Error en el Sistema',
                        'errors'  => [
                            "Error al actualizar cliente Persona Natural, por favor comuniquese con el area de Tecnología de Sajona, Gracias".$e
                        ]
                    ], 500);
                }
            }
        }

        return response()->json([
            'message' => "Datos Actualizados con exito.",
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
