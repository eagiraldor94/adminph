<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use adminph;

class ControladorParametros extends Controller
{
	/*===================================
	=            USER EDIT            =
	===================================*/
	
	static public function ctrEditarParametro(){
			$answer = adminph\Parameter::find($_POST['idParametro']);
		   	$answer->value = $_POST['newValue'];
		   	$answer->save();
	 	}	
	static public function ctrEditarFirma(){
			array_map('unlink', array_filter((array) glob("Views/img/firma/*")));
			   	if (isset($_FILES['sign']['tmp_name']) && !empty($_FILES['sign']['tmp_name'])) {
			   		list($ancho,$alto) = getimagesize($_FILES['sign']['tmp_name']);
			   		$nuevoAncho = 178;
			   		$nuevoAlto = 75;
			   		/*==========================================
			   		=            CREANDO DIRECTORIO            =
			   		==========================================*/
			   		$directorio = "Views/img/firma";
			   		/*===========================================================================
			   		=            Funciones defecto PHP dependiendo de tipo de imagen            =
			   		===========================================================================*/
			   		switch ($_FILES['sign']['type']) {
			   			case 'image/jpeg':
			   				$ruta = $directorio.'/'.$_FILES['sign']['name'];
			   				$origen = imagecreatefromjpeg($_FILES['sign']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				break;
			   			case 'image/png':
			   				$ruta = $directorio.'/'.$_FILES['sign']['name'];
			   				$origen = imagecreatefrompng($_FILES['sign']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagepng($destino,$ruta);
			   				break;
			   			default:
			   				# code...
			   				break;
			   		}
			   	}
			$answer = adminph\Parameter::where('name','Firma Digital')->first();
		   	$answer->value = $ruta;
		   	$answer->save();
		   	return redirect('parametros');
	 	}	
	public function ajaxConsultarParametro(){
		$answer = adminph\Parameter::find($_POST['idParametro']);
		echo json_encode($answer);
	} 
}
