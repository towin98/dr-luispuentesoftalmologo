<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait metodosComunesTrait {

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

    /**
     * Método que guarda archivo subido a nivel de public.
     *
     * @param string $archivo
     * @param Request $request
     * @param string $nombreCampo
     * @return string Ruta de donde se movio o guardo archivo.
     */
    public function guardarArchivoSubido(Request $request, $nombreCampo, $carpetaMover){
        if ($request->$nombreCampo != "") {
            $file = $request->file($nombreCampo);
            $fileName = uniqid() . $file->getClientOriginalName();
            $file->move($carpetaMover,  $fileName);
            return  $carpetaMover ."/".$fileName;
        }else{
            return "";
        }
    }

    public function fnBuscarUltimoNumeroDisponible(){

    }
}
?>
