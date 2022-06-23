<?php

namespace App\Traits\Parametricas;

use App\Models\Parametro\Eps;
use App\Models\parametro\ocupacion;

trait ParametricaTrait {

    static $messages = [
        'codigo.required'               => 'El Código es requerida.',
        'codigo.max'                    => 'El Código no debe superar los 25 carácteres.',
        'descripcion.required'          => 'La descripción es requerida.',
        'descripcion.max'               => 'La descripcion no debe superar los 50 carácteres.',
        'estado.required'               => 'El estado es requerido.',
        'estado.in'                     => 'El estado debe ser ACTIVO o INACTIVO.',
    ];

    static $rules = [
        'descripcion'             => 'required|string|max:25',
        'descripcion'             => 'required|string|max:50',
        'estado'                  => 'required|string|in:ACTIVO,INACTIVO',
    ];

    /**
     * Diccionario de datos para almacenar los Modelos de las paramétricas.
     *
     * @var array
     */
    public $arrayModelos = [
        'p_eps'                    => Eps::class,
        'p_ocupacion'              => ocupacion::class,
    ];

    /**
     * Diccionario de datos para almacenar campos parametros.
     *
     * @var array
     */
    public $arrayCamposParametros = [

        'p_eps'                    => 'Eps',
        'p_ocupacion'              => 'Ocupación',
    ];

    /**
     * Obtiene el Modelo de una paramétrica.
     *
     * @param string $parametrica Nombre de la paramétrica
     * @return string namespace del Modelo asociado a la paramétrica.
     */
    public function getModelo($parametrica){
        return isset($this->arrayModelos[$parametrica]) ? $this->arrayModelos[$parametrica] : '';
    }

    /**
     * Obtiene el nombre del campo parametro.
     *
     * @param string $parametrica Nombre de la tabla parametro para el campo.
     * @return string nombre del campo parámetro.
     */
    public function getCampoParametro($parametrica){
        return isset($this->arrayCamposParametros[$parametrica]) ? $this->arrayCamposParametros[$parametrica] : '';
    }
}
?>
