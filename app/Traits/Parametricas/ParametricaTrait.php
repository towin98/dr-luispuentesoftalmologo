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

    /**
     * Método que elimina cadena con posible tildes.
     *
     * @param string $cadena
     * @return string $cadena sin tildes
     */
    public function fnEliminarTildes($cadena){
		//Codificamos la cadena en formato utf8 en caso de que nos de errores
		// $cadena = utf8_encode($cadena);

		//Ahora reemplazamos las letras
		$cadena = str_replace(array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
													array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
													$cadena);

		$cadena = str_replace(array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
													array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
													$cadena);

		$cadena = str_replace(array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
													array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
													$cadena);

		$cadena = str_replace(array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
													array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
													$cadena);

		$cadena = str_replace(array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
													array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
													$cadena);

		$cadena = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'),
													array('n', 'N', 'c', 'C'),
													$cadena);

		return $cadena;
	}
}
?>
