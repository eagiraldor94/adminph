<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use adminph;

class ControladorArrendatarios extends Controller
{
	/*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearArrendatario(){

		if (isset($_POST['newLessee'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"]) &&
			   preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["newUsername"])) {
			   	/*======================================
			   	=            Validar Imagen            =
			   	======================================*/
			   	$ruta="";
			   	if (isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name'])) {
			   		list($ancho,$alto) = getimagesize($_FILES['photo']['tmp_name']);
			   		$nuevoAncho = 500;
			   		$nuevoAlto = 500;
			   		/*==========================================
			   		=            CREANDO DIRECTORIO            =
			   		==========================================*/
			   		$directorio = "Views/img/arrendatarios/".$_POST['newUsername'];
			   		mkdir($directorio,0755);
			   		/*===========================================================================
			   		=            Funciones defecto PHP dependiendo de tipo de imagen            =
			   		===========================================================================*/
			   		switch ($_FILES['photo']['type']) {
			   			case 'image/jpeg':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newUsername'].'_'.$preruta.'.jpg';
			   				$origen = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				break;
			   			case 'image/png':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newUsername'].'_'.$preruta.'.png';
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
			   	$answer = new adminph\Lessee();
			   	$answer->property_id = $_POST['newPropertyId'];
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->name = $_POST['newName'];
			   	$answer->phone = $_POST['newPhone'];
			   	$answer->email = $_POST['newEmail'];
			   	$answer->username = $_POST['newUsername'];
			   	$answer->password = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
			   	$answer->photo = $ruta;
			   if ($answer->save()) {
			   	return redirect('arrendatarios');
			   }
			 } else {
			 	return view('layouts.lessees_error');
			 }
		}

	}
	/*===================================
	=            USER EDIT            =
	===================================*/
	
	static public function ctrEditarArrendatario(){

		if (isset($_POST['editLessee'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"])) {
			   	/*======================================
			   	=            Validar Imagen             =
			   	======================================*/
			   	$ruta=$_POST['lastPhoto'];
			   	if (isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name'])) {
			   		list($ancho,$alto) = getimagesize($_FILES['photo']['tmp_name']);
			   		$nuevoAncho = 500;
			   		$nuevoAlto = 500;
			   		/*==========================================
			   		=            CREANDO DIRECTORIO            =
			   		==========================================*/
			   		$directorio = "Views/img/arrendatarios/".$_POST['newUsername'];
			   		if (!empty($_POST['lastPhoto'])) {
			   			unlink($_POST['lastPhoto']);
			   		}else{
			   			mkdir($directorio,0755);
			   		}
			   		
			   		
			   		/*===========================================================================
			   		=            Funciones defecto PHP dependiendo de tipo de imagen            =
			   		===========================================================================*/
			   		switch ($_FILES['photo']['type']) {
			   			case 'image/jpeg':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newUsername'].'_'.$preruta.'.jpg';
			   				$origen = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				break;
			   			case 'image/png':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newUsername'].'_'.$preruta.'.png';
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
				$answer = adminph\Lessee::where('username',$_POST['newUsername'])->first();
			   	if ($_POST['newPassword'] != "") {
			   		$password = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
			   	}else{
			   		$password=$_POST['password'];
			   	}
			   	$answer->property_id = $_POST['newPropertyId'];
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->name = $_POST['newName'];
			   	$answer->phone = $_POST['newPhone'];
			   	$answer->email = $_POST['newEmail'];
			   	$answer->username = $_POST['newUsername'];
			   	$answer->password = $password;
			   	$answer->photo = $ruta;
			   if ($answer->save()) {
			   	return redirect('arrendatarios');			   }
			 } else {
			 	return view('layouts.lessees_error');
			 }
		}

	}
	/*======================================
	=            Borrar Arrendatario            =
	======================================*/
	static public function ctrBorrarArrendatario(){
		if (isset($_POST['idArrendatario'])) {
			if ($_POST['fotoArrendatario'] != "") {
				unlink($_POST["fotoArrendatario"]);
				rmdir('Views/img/arrendatarios/'.$_POST['arrendatario']);
			}
		$answer=adminph\Lessee::find($_POST['idArrendatario']);
		$answer->delete();
		}
	}
	public function ajaxEditarArrendatario(){
		$answer = adminph\Lessee::find($_POST['idArrendatario']);
		echo json_encode($answer);
	} 
	public function ajaxActivarArrendatario(){
		$answer = adminph\Lessee::find($_POST['activarArrendatario']);
		$answer->state = $_POST['estadoArrendatario'];
		$answer->save();
	} 
	public function ajaxCheckearArrendatario(){
		$answer = adminph\Lessee::where('username',$_POST['userCheck'])->first();
		echo json_encode($answer);
	}
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatableArrendatarios()
	{	
  	$productos = adminph\Lessee::all();

  	echo '{
			"data": [';

			for($i = 0; $i < count($productos)-1; $i++){
				/*=============================
				=            Stock            =
				=============================*/
				
	            if($productos[$i]->state == 1){
	            	$state="<td><button class='btn btn-success btn-sm btnActivar' idArrendatario='".$productos[$i]->id."' estadoArrendatario='0'>Activado</button></td>";
	            }else{
	            	$state="<td><button class='btn btn-danger btn-sm btnActivar' idArrendatario='".$productos[$i]->id."' estadoArrendatario='1'>Desactivado</button></td>";
	            }
                    $buttons ="<div class='btn-group'><button class='btn btn-warning btnEditarArrendatario' idArrendatario='".$productos[$i]->id."' data-toggle='modal' data-target='#modalEditarArrendatario'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarArrendatario' idArrendatario='".$productos[$i]->id."' fotoArrendatario='".$productos[$i]->photo."' arrendatario='".$productos[$i]->username."'><i class='fa fa-times'></i></button></div>";
				 echo '[
			      "'.($i+1).'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->property->apartment.'",
			      "'.$productos[$i]->name.'",
			      "'.$productos[$i]->phone.'",
			      "'.$productos[$i]->email.'",
			      "'.$productos[$i]->username.'",
			      "'.$state.'",
			      "'.$productos[$i]->last_log.'",
			      "'.$buttons.'"
			    ],';

			}
				/*=============================
				=            Stock            =
				=============================*/
				
	            if($productos[count($productos)-1]->state == 1){
	            	$state="<td><button class='btn btn-success btn-sm btnActivar' idArrendatario='".$productos[count($productos)-1]->id."' estadoArrendatario='0'>Activado</button></td>";
	            }else{
	            	$state="<td><button class='btn btn-danger btn-sm btnActivar' idArrendatario='".$productos[count($productos)-1]->id."' estadoArrendatario='1'>Desactivado</button></td>";
	            }
                    $buttons ="<div class='btn-group'><button class='btn btn-warning btnEditarArrendatario' idArrendatario='".$productos[count($productos)-1]->id."' data-toggle='modal' data-target='#modalEditarArrendatario'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarArrendatario' idArrendatario='".$productos[count($productos)-1]->id."' fotoArrendatario='".$productos[count($productos)-1]->photo."' arrendatario='".$productos[count($productos)-1]->username."'><i class='fa fa-times'></i></button></div>";
				 echo '[
			      "'.(count($productos)).'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->property->apartment.'",
			      "'.$productos[count($productos)-1]->name.'",
			      "'.$productos[count($productos)-1]->phone.'",
			      "'.$productos[count($productos)-1]->email.'",
			      "'.$productos[count($productos)-1]->username.'",
			      "'.$state.'",
			      "'.$productos[count($productos)-1]->last_log.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
}
