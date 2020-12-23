<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use SplFileInfo;
use adminph;

class ControladorAnuncios extends Controller
{
    /*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearClasificado(){

		if (isset($_POST['newAdd'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\.\,\@\- ]+$/', $_POST["newEmail"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\.\,\(\)\- ]+$/', $_POST["newBody"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\.\,\(\)\- ]+$/', $_POST["newSubject"]) &&
				preg_match('/^[0-9\(\)\- ]+$/', $_POST["newPhone"])
			) {
			   	/*======================================
			   	=            Validar Imagen            =
			   	======================================*/
			   	$ruta="";
			   	if (isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name'])) {
			   		list($ancho,$alto) = getimagesize($_FILES['photo']['tmp_name']);
			   		$nuevoAncho = 400;
			   		$nuevoAlto = 300;
			   		/*==========================================
			   		=            CREANDO DIRECTORIO            =
			   		==========================================*/
			   		$directorio = "Views/img/clasificados";
			   		/*===========================================================================
			   		=            Funciones defecto PHP dependiendo de tipo de imagen            =
			   		===========================================================================*/
			   		switch ($_FILES['photo']['type']) {
			   			case 'image/jpeg':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$preruta.$_FILES['photo']['name'];
			   				$origen = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				break;
			   			case 'image/png':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$preruta.$_FILES['photo']['name'];
			   				$origen = imagecreatefrompng($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagepng($destino,$ruta);
			   				break;
			   			default:
			   				# code...
			   				break;
			   		}
			   	}
				$info = new SplFileInfo($_FILES['document']['name']);
				$info = $info->getExtension();
			   	$ruta2="";
			   	if ($info=='pdf' || $info=='png' || $info=='jpg' || $info=='jpeg' ) {
			   	$ruta2="";
	   				$preruta = date('Y-m-d_his');
	   				$preruta = (string)$preruta;
				   	if (isset($_FILES['document']['tmp_name']) && !empty($_FILES['document']['tmp_name'])) {
					   	$ruta2 = "Views/reports/";
					   	$ruta2 = $ruta2 . $preruta . basename($_FILES['document']['name']) ;
					   	if(move_uploaded_file($_FILES['document']['tmp_name'], $ruta2)) {
					   	}else {
					   		$ruta2 = "";
					   	}
				   	}
				}
				switch (session('rank')) {
					case 'Encargado':
						$user = adminph\Attendant::find(session('id'));
						break;
					case 'Propietario':
						$user = adminph\Propietary::find(session('id'));
						break;
					case 'Arrendatario':
						$user = adminph\Lessee::find(session('id'));
						break;
					default:
						break;
				}
			   	$organization = $user->organization;
			   	$property = $user->property;
			   	$answer = new adminph\Add();
			   	$answer->organization_id = $organization->id;
			   	$answer->property_id = $property->id;
			   	$answer->subject = $_POST['newSubject'];
			   	$answer->body = $_POST['newBody'];
			   	$answer->phone = $_POST['newPhone'];
			   	$answer->email = $_POST['newEmail'];
			   	$answer->name = $user->name;
			   	$answer->photo = $ruta;
			   	$answer->document = $ruta2;
			   if ($answer->save()) {
			   	return redirect('clasificados');
			   }
			 } else {
			 	return view('layouts.adds_public_error');
			 }
		}

	}
	/*======================================
	=            Borrar Boletin            =
	======================================*/
	static public function ctrBorrarClasificado(){
		if (isset($_POST['idClasificado'])) {
		if ($_POST['fotoClasificado'] != "") {
			unlink($_POST['fotoClasificado']);
		}
		if ($_POST['documentoClasificado'] != "") {
			unlink($_POST['documentoClasificado']);
		}
		$answer=adminph\Add::find($_POST['idClasificado']);
		$answer->delete();
		}
	}
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatableClasificados(){	
	if (session('rank')=='Admin') {
  		$productos = adminph\Add::all();
	  }

  	echo '{
			"data": [';
			$buttons = "";
			for($i = 0; $i < count($productos)-1; $i++){
				/*=============================
				=            Stock            =
				=============================*/
	            if($productos[$i]->photo != "" && $productos[$i]->photo != null){
	            	$photo="<img src='".$productos[$i]->photo."' class='img-thumbnail' width='40px'>";
	            }else{
	            	$photo="";
	            }
	            if($productos[$i]->authorized == 1){
	            	$auth="<div class='btn-group'><button class='btn btn-success'>Autorizado</button></div>";
	            }else{
	            	$auth="<div class='btn-group'><button class='btn btn-danger'>No autorizado</button></div>";
	            }
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><button class='btn btn-warning btnAutorizarClasificado' idClasificado='".$productos[$i]->id."' data-toggle='modal' data-target='#modalAutorizarClasificado'><i class='fas fa-shield-alt'></i></button><button class='btn btn-danger btnBorrarClasificado' idClasificado='".$productos[$i]->id."' fotoClasificado='".$productos[$i]->photo."' documentoClasificado='".$productos[$i]->document."'><i class='fa fa-times'></i></button></div>";
                }else{
                	$buttons="";
                }
				 echo '[
			      "'.($i+1).'",
			      "'.$photo.'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->property->apartment.'",
			      "'.$productos[$i]->subject.'",
			      "'.$productos[$i]->phone.'",
			      "'.$productos[$i]->email.'",
			      "'.$auth.'",
			      "'.$buttons.'"
			    ],';

			}
				/*=============================
				=            Stock            =
				=============================*/
	            if($productos[count($productos)-1]->photo != "" && $productos[count($productos)-1]->photo != null){
	            	$photo="<img src='".$productos[count($productos)-1]->photo."' class='img-thumbnail' width='40px'>";
	            }else{
	            	$photo="";
	            }
	            if($productos[count($productos)-1]->authorized == 1){
	            	$auth="<div class='btn-group'><button class='btn btn-success'>Autorizado</button></div>";
	            }else{
	            	$auth="<div class='btn-group'><button class='btn btn-danger'>No autorizado</button></div>";
	            }
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><button class='btn btn-warning btnAutorizarClasificado' idClasificado='".$productos[count($productos)-1]->id."' data-toggle='modal' data-target='#modalAutorizarClasificado'><i class='fas fa-shield-alt'></i></button><button class='btn btn-danger btnBorrarClasificado' idClasificado='".$productos[count($productos)-1]->id."' fotoClasificado='".$productos[count($productos)-1]->photo."' documentoClasificado='".$productos[count($productos)-1]->document."'><i class='fa fa-times'></i></button></div>";
                }else{
                	$buttons="";
                }
				 echo '[
			      "'.(count($productos)).'",
			      "'.$photo.'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->property->apartment.'",
			      "'.$productos[count($productos)-1]->subject.'",
			      "'.$productos[count($productos)-1]->phone.'",
			      "'.$productos[count($productos)-1]->email.'",
			      "'.$auth.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
	public function ctrAutorizarClasificado(){
		if (isset($_POST['newAuth'])) {
			$answer=adminph\Add::find($_POST['newAuthId']);
		   	$answer->authorized = 1;
			$answer->save();
			return redirect('clasificados');
		}
	}
	public function ajaxEditarClasificado(){
		$answer = adminph\Add::find($_POST['idClasificado'])->load('organization')->load('property');
		echo json_encode($answer);
	} 
}
