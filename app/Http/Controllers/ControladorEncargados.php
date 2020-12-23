<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use adminph;

class ControladorEncargados extends Controller
{
	/*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearEncargado(){

		if (isset($_POST['newAttendant'])) {
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
			   		$directorio = "Views/img/encargados/".$_POST['newUsername'];
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
			   	$answer = new adminph\Attendant();
			   	$answer->property_id = $_POST['newPropertyId'];
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->name = $_POST['newName'];
			   	$answer->id_type = $_POST['newIdType'];
			   	$answer->id_number = $_POST['newIdNumber'];
			   	$answer->phone = $_POST['newPhone'];
			   	$answer->email = $_POST['newEmail'];
			   	$answer->address = $_POST['newAddress'];
			   	$answer->username = $_POST['newUsername'];
			   	$answer->password = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
			   	$answer->photo = $ruta;
			   if ($answer->save()) {
			   	return redirect('encargados');
			   }
			 } else {
			 	return view('layouts.attendants_error');
			 }
		}

	}
	/*===================================
	=            USER EDIT            =
	===================================*/
	
	static public function ctrEditarEncargado(){

		if (isset($_POST['editAttendant'])) {
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
			   		$directorio = "Views/img/encargados/".$_POST['newUsername'];
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
				$answer = adminph\Attendant::where('username',$_POST['newUsername'])->first();
			   	if ($_POST['newPassword'] != "") {
			   		$password = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
			   	}else{
			   		$password=$_POST['password'];
			   	}
			   	$answer->property_id = $_POST['newPropertyId'];
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->name = $_POST['newName'];
			   	$answer->id_type = $_POST['newIdType'];
			   	$answer->id_number = $_POST['newIdNumber'];
			   	$answer->phone = $_POST['newPhone'];
			   	$answer->email = $_POST['newEmail'];
			   	$answer->address = $_POST['newAddress'];
			   	$answer->username = $_POST['newUsername'];
			   	$answer->password = $password;
			   	$answer->photo = $ruta;
			   if ($answer->save()) {
			   	return redirect('encargados');			   }
			 } else {
			 	return view('layouts.attendants_error');
			 }
		}

	}
	/*======================================
	=            Borrar Encargado            =
	======================================*/
	static public function ctrBorrarEncargado(){
		if (isset($_POST['idEncargado'])) {
			if ($_POST['fotoEncargado'] != "") {
				unlink($_POST["fotoEncargado"]);
				rmdir('Views/img/encargados/'.$_POST['encargado']);
			}
		$answer=adminph\Attendant::find($_POST['idEncargado']);
		$answer->delete();
		}
	}
	public function ajaxEditarEncargado(){
		$answer = adminph\Attendant::find($_POST['idEncargado']);
		echo json_encode($answer);
	} 
	public function ajaxActivarEncargado(){
		$answer = adminph\Attendant::find($_POST['activarEncargado']);
		$answer->state = $_POST['estadoEncargado'];
		$answer->save();
	} 
	public function ajaxCheckearEncargado(){
		$answer = adminph\Attendant::where('username',$_POST['userCheck'])->first();
		echo json_encode($answer);
	} 
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatableEncargados()
	{	
  	$productos = adminph\Attendant::all();

  	echo '{
			"data": [';

			for($i = 0; $i < count($productos)-1; $i++){
				/*=============================
				=            Stock            =
				=============================*/
				
	            if($productos[$i]->state == 1){
	            	$state="<td><button class='btn btn-success btn-sm btnActivar' idEncargado='".$productos[$i]->id."' estadoEncargado='0'>Activado</button></td>";
	            }else{
	            	$state="<td><button class='btn btn-danger btn-sm btnActivar' idEncargado='".$productos[$i]->id."' estadoEncargado='1'>Desactivado</button></td>";
	            }
                    $buttons ="<div class='btn-group'><button class='btn btn-warning btnEditarEncargado' idEncargado='".$productos[$i]->id."' data-toggle='modal' data-target='#modalEditarEncargado'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarEncargado' idEncargado='".$productos[$i]->id."' fotoEncargado='".$productos[$i]->photo."' encargado='".$productos[$i]->username."'><i class='fa fa-times'></i></button></div>";
				 echo '[
			      "'.($i+1).'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->property->apartment.'",
			      "'.$productos[$i]->name.'",
			      "<b>'.$productos[$i]->id_type.'</b>",
			      "'.$productos[$i]->id_number.'",
			      "'.$productos[$i]->phone.'",
			      "'.$productos[$i]->email.'",
			      "'.$productos[$i]->address.'",
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
	            	$state="<td><button class='btn btn-success btn-sm btnActivar' idEncargado='".$productos[count($productos)-1]->id."' estadoEncargado='0'>Activado</button></td>";
	            }else{
	            	$state="<td><button class='btn btn-danger btn-sm btnActivar' idEncargado='".$productos[count($productos)-1]->id."' estadoEncargado='1'>Desactivado</button></td>";
	            }
                    $buttons ="<div class='btn-group'><button class='btn btn-warning btnEditarEncargado' idEncargado='".$productos[count($productos)-1]->id."' data-toggle='modal' data-target='#modalEditarEncargado'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarEncargado' idEncargado='".$productos[count($productos)-1]->id."' fotoEncargado='".$productos[count($productos)-1]->photo."' encargado='".$productos[count($productos)-1]->username."'><i class='fa fa-times'></i></button></div>";
				 echo '[
			      "'.(count($productos)).'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->property->apartment.'",
			      "'.$productos[count($productos)-1]->name.'",
			      "<b>'.$productos[count($productos)-1]->id_type.'</b>",
			      "'.$productos[count($productos)-1]->id_number.'",
			      "'.$productos[count($productos)-1]->phone.'",
			      "'.$productos[count($productos)-1]->email.'",
			      "'.$productos[count($productos)-1]->address.'",
			      "'.$productos[count($productos)-1]->username.'",
			      "'.$state.'",
			      "'.$productos[count($productos)-1]->last_log.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
}
