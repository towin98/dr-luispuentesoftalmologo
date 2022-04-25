<?php

namespace App\Http\Controllers\HistoriaClinica;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class HistoriaClinicaController extends Controller
{
    /**
     * Método que busca registros de un paciente.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function buscar(Request $request)
    {

        // Se válida si envian los parámetros length y start.
        if ($request->has(['length', 'start'])) {
            $length = $request->length;
            $start  = $request->start;
        } else {
            $length = 15;
            $start  = 0;
        }

        $bRequestVacio = true;
        $registros = Cliente::select('*');

        if ($request->tipo_documento != "") {
            $bRequestVacio = false;
            $registros = $registros->where('tipo_documento','LIKE', "%$request->tipo_documento%");
        }
        if ($request->numero_documento != "") {
            $bRequestVacio = false;
            $registros = $registros->where('numero_documento','LIKE', "%$request->numero_documento%");
        }
        if ($request->nombre != "") {
            $bRequestVacio = false;
            $registros = $registros->where('nombre','LIKE', "%$request->nombre%");
        }
        if ($request->apellido != "") {
            $bRequestVacio = false;
            $registros = $registros->where('apellido','LIKE', "%$request->apellido%");
        }

        // Si no se envia ningun request.
        if ($bRequestVacio == true && $request->listar_todos != "SI") {
            return response()->json([
                'data'      => [],
                'filtrados' => 0,
                'total'     => 0
            ], 200);
        }else{
            $registros = $registros->Ordenamiento($request->orderColumn, $request->order);

            // consulta para saber cuantos registros hay.
            $totalRegistros = $registros->count();

            $registros = $registros->skip($start)
                ->take($length)
                ->get();
        }

        return response()->json([
            'data'      => $registros,
            'filtrados' => $registros->count(),
            'total'     => $totalRegistros,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
