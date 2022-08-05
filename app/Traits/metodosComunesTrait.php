<?php

namespace App\Traits;

use App\Models\alerta;
use Throwable;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

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
            $fileName = uniqid() ."_". $file->getClientOriginalName();
            $file->move($carpetaMover,  $fileName);
            return  $carpetaMover ."/".$fileName;
        }else{
            return null;
        }
    }

    /**
     * Método que proceso imagenes subidas de refracciones y las agrega a un pdf.
     *
     * @param Request $request
     * @param integer $numero_evolucion
     * @return array Si es false el retorno es porque sucedio un error en el proceso.
     */
    public function fnPdfRefracciones(Request $request, $numero_evolucion){
        $html = "";
        $arrPathArchivos = [];

        $vReturn[0] = ""; // String "true" o "false", si es false ocurrio error en el proceso.
        $vReturn[1] = ""; // Retorno de nombre pdf generado.

        try {
            foreach($request->file('refracciones') as $file){

                $nombreArchivo = uniqid()."_".$file->getClientOriginalName();
                $pathArchivo = public_path('storage/img-refracciones-temporal/').$nombreArchivo;

                // Reduciendo tamaño de imagen. (null =>ancho automatico)
                Image::make($file)->resize(null,700, function ($constraint){
                                $constraint->aspectRatio();
                            })
                            ->save($pathArchivo,90); // valor 0 minima calidad, maxima 100

                // Guardando ruta de iamgen en array para al final de proceso eliminarla.
                $arrPathArchivos[] = $pathArchivo;

                $html .= "<center><img src='".$pathArchivo."' style='max-width: 700px;
                                                                    max-height: 1000px;
                                                                    border: 2px solid black'></center>";
                $html .= "<br><br>";
            }

            $pdf = PDF::loadHTML($html)->output();
            $nombrePdf  = date('YmdHis')."_refracciones_$numero_evolucion.pdf";
            $vReturn[1] = $nombrePdf;
            file_put_contents(public_path('storage/refracciones/').$nombrePdf, $pdf);

            // Eliminando archivos subidos de la carpeta img-refracciones-temporal
            File::delete($arrPathArchivos);
            $vReturn[0] = "true";
        } catch (Throwable $e) {
            $vReturn[0] = "false";
            $vReturn[2] = $e;
        }
        return $vReturn;
    }

    /**
     * Método que verifica si existe directorio dentro de public, si no esta lo crea.
     *
     * @param string $path Ruta a comprobar si existe
     * @param integer $permisos con que se crea directorio si no existe.
     * @return void
     */
    public function fnCheckDirectoryPublic($path, $permisos = 0777){
        if (!file_exists(public_path($path))) {
            File::makeDirectory(public_path($path), $permisos);
        }
    }
}
?>
