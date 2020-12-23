<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use adminph;

class ControladorPropietarios extends Controller
{
	/*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearPropietario(){

		if (isset($_POST['newPropietary'])) {
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
			   		$directorio = "Views/img/propietarios/".$_POST['newUsername'];
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
			   	$answer = new adminph\Propietary();
			   	$answer->property_id = $_POST['newPropertyId'];
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->name = $_POST['newName'];
			   	$answer->id_type = $_POST['newIdType'];
			   	$answer->id_number = $_POST['newIdNumber'];
			   	$answer->phone1 = $_POST['newPhone1'];
			   	$answer->phone2 = $_POST['newPhone2'];
			   	$answer->email1 = $_POST['newEmail1'];
			   	$answer->email2 = $_POST['newEmail2'];
			   	$answer->address = $_POST['newAddress'];
			   	$answer->username = $_POST['newUsername'];
			   	$answer->password = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
			   	$answer->photo = $ruta;
			   if ($answer->save()) {
			   	return redirect('propietarios');
			   }
			 } else {
			 	return view('layouts.propietarys_error');
			 }
		}

	}
	/*===================================
	=            USER EDIT            =
	===================================*/
	
	static public function ctrEditarPropietario(){

		if (isset($_POST['editPropietary'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"]) &&
			   preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["newUsername"])) {
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
			   		$directorio = "Views/img/propietarios/".$_POST['newUsername'];
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
				$answer = adminph\Propietary::where('username',$_POST['newUsername'])->first();
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
			   	$answer->phone1 = $_POST['newPhone1'];
			   	$answer->phone2 = $_POST['newPhone2'];
			   	$answer->email1 = $_POST['newEmail1'];
			   	$answer->email2 = $_POST['newEmail2'];
			   	$answer->address = $_POST['newAddress'];
			   	$answer->username = $_POST['newUsername'];
			   	$answer->password = $password;
			   	$answer->photo = $ruta;
			   if ($answer->save()) {
			   	return redirect('propietarios');			   }
			 } else {
			 	return view('layouts.propietarys_error');
			 }
		}

	}
	/*======================================
	=            Borrar Propietario            =
	======================================*/
	static public function ctrBorrarPropietario(){
		if (isset($_POST['idPropietario'])) {
			if ($_POST['fotoPropietario'] != "") {
				unlink($_POST["fotoPropietario"]);
				rmdir('Views/img/propietarios/'.$_POST['propietario']);
			}
		$answer=adminph\Propietary::find($_POST['idPropietario']);
		$answer->delete();
		}
	}
	public function ajaxEditarPropietario(){
		$answer = adminph\Propietary::find($_POST['idPropietario']);
		echo json_encode($answer);
	} 
	public function ajaxActivarPropietario(){
		$answer = adminph\Propietary::find($_POST['activarPropietario']);
		$answer->state = $_POST['estadoPropietario'];
		$answer->save();
	} 
	public function ajaxCheckearPropietario(){
		$answer = adminph\Propietary::where('username',$_POST['userCheck'])->first();
		echo json_encode($answer);
	} 
	/*======================================
	=           Subir propiedades          =
	======================================*/
	static public function ctrSubirPropietarios(){
		$handle = fopen($_FILES['propietarios']['tmp_name'], "r");

		while ($csvLine = fgetcsv($handle, 1000, ";")) {
				$csvLine = array_map("utf8_encode", $csvLine); //added
			   	$organization = adminph\Organization::where('code',$csvLine[1])->first();
			   	$property = adminph\Property::where('organization_id',$organization->id)->where('apartment',$csvLine[0])->first();
				if (is_object($organization) && is_object($property)) {

				   	$answer = new adminph\Propietary();
				   	$answer->organization_id = $organization->id;
				   	$answer->property_id = $property->id;
				   	$answer->name = $csvLine[2];
				   	$answer->id_type = $csvLine[3];
				   	$answer->id_number = $csvLine[4];
				   	$answer->phone1 = $csvLine[5];
				   	$answer->phone2 = $csvLine[6];
				   	$answer->email1 = $csvLine[7];
				   	$answer->email2 = $csvLine[8];
				   	$answer->address = $csvLine[9];
				   	$answer->username = $csvLine[10];
				   	$answer->password = password_hash($csvLine[11], PASSWORD_DEFAULT);
				    $answer->save();
		    	}
		}
		
	   	return redirect('propietarios');

	}
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatablePropietarios()
	{	
  	$productos = adminph\Propietary::orderBy('property_id')->get();

  	echo '{
			"data": [';

			for($i = 0; $i < count($productos)-1; $i++){
				/*=============================
				=            Stock            =
				=============================*/
				
	            if($productos[$i]->state == 1){
	            	$state="<td><button class='btn btn-success btn-sm btnActivar' idPropietario='".$productos[$i]->id."' estadoPropietario='0'>Activado</button></td>";
	            }else{
	            	$state="<td><button class='btn btn-danger btn-sm btnActivar' idPropietario='".$productos[$i]->id."' estadoPropietario='1'>Desactivado</button></td>";
	            }
                    $buttons ="<div class='btn-group'><button class='btn btn-warning btnEditarPropietario' idPropietario='".$productos[$i]->id."' data-toggle='modal' data-target='#modalEditarPropietario'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarPropietario' idPropietario='".$productos[$i]->id."' fotoPropietario='".$productos[$i]->photo."' propietario='".$productos[$i]->username."'><i class='fa fa-times'></i></button></div>";
				 echo '[
			      "'.($i+1).'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->property->apartment.'",
			      "'.$productos[$i]->name.'",
			      "<b>'.$productos[$i]->id_type.'</b>",
			      "'.$productos[$i]->id_number.'",
			      "'.$productos[$i]->phone1.' - '.$productos[$i]->phone2.'",
			      "'.$productos[$i]->email1.' - '.$productos[$i]->email2.'",
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
	            	$state="<td><button class='btn btn-success btn-sm btnActivar' idPropietario='".$productos[count($productos)-1]->id."' estadoPropietario='0'>Activado</button></td>";
	            }else{
	            	$state="<td><button class='btn btn-danger btn-sm btnActivar' idPropietario='".$productos[count($productos)-1]->id."' estadoPropietario='1'>Desactivado</button></td>";
	            }
                    $buttons ="<div class='btn-group'><button class='btn btn-warning btnEditarPropietario' idPropietario='".$productos[count($productos)-1]->id."' data-toggle='modal' data-target='#modalEditarPropietario'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarPropietario' idPropietario='".$productos[count($productos)-1]->id."' fotoPropietario='".$productos[count($productos)-1]->photo."' propietario='".$productos[count($productos)-1]->username."'><i class='fa fa-times'></i></button></div>";
				 echo '[
			      "'.(count($productos)).'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->property->apartment.'",
			      "'.$productos[count($productos)-1]->name.'",
			      "<b>'.$productos[count($productos)-1]->id_type.'</b>",
			      "'.$productos[count($productos)-1]->id_number.'",
			      "'.$productos[count($productos)-1]->phone1.' - '.$productos[count($productos)-1]->phone2.'",
			      "'.$productos[count($productos)-1]->email1.' - '.$productos[count($productos)-1]->email2.'",
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
