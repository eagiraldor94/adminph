<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use adminph;

class ControladorUnidades extends Controller
{
	
	/*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearUnidad(){

		if (isset($_POST['newOrganization'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"])) {
			   	/*======================================
			   	=            Validar Imagen            =
			   	======================================*/
			   	$ruta="";
			   	$ruta2="";
			   	if (isset($_FILES['logo']['tmp_name']) && !empty($_FILES['logo']['tmp_name'])) {
			   		list($ancho,$alto) = getimagesize($_FILES['logo']['tmp_name']);
			   		$nuevoAncho = 400;
			   		$nuevoAlto = 230;
			   		$nuevoAncho2 = 178;
			   		$nuevoAlto2 = 75;
			   		/*==========================================
			   		=            CREANDO DIRECTORIO            =
			   		==========================================*/
			   		$directorio = "Views/img/organizaciones/".$_POST['newCode'];
			   		mkdir($directorio,0755);
			   		/*===========================================================================
			   		=            Funciones defecto PHP dependiendo de tipo de imagen            =
			   		===========================================================================*/
			   		switch ($_FILES['logo']['type']) {
			   			case 'image/jpeg':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newCode'].'_'.$preruta.'.jpg';
			   				$ruta2 = $directorio.'/'.$_POST['newCode'].'_'.$preruta.'2.jpg';
			   				$origen = imagecreatefromjpeg($_FILES['logo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				$destino2 = imagecreatetruecolor($nuevoAncho2, $nuevoAlto2);
			   				imagecopyresized($destino2, $origen, 0, 0, 0, 0, $nuevoAncho2, $nuevoAlto2, $ancho, $alto);
			   				imagejpeg($destino2,$ruta2);
			   				break;
			   			case 'image/png':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newCode'].'_'.$preruta.'.png';
			   				$ruta = $directorio.'/'.$_POST['newCode'].'_'.$preruta.'2.png';
			   				$origen = imagecreatefrompng($_FILES['logo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagepng($destino,$ruta);
			   				$destino2 = imagecreatetruecolor($nuevoAncho2, $nuevoAlto2);
			   				imagecopyresized($destino2, $origen, 0, 0, 0, 0, $nuevoAncho2, $nuevoAlto2, $ancho, $alto);
			   				imagepng($destino2,$ruta2);
			   				break;
			   			default:
			   				# code...
			   				break;
			   		}
			   		
			   		
			   	}
			   	$answer = new adminph\Organization();
			   	$answer->name = $_POST['newName'];
			   	$answer->code = $_POST['newCode'];
			   	$answer->NIT = $_POST['newNIT'];
			   	$answer->address = $_POST['newAddress'];
			   	$answer->phone = $_POST['newPhone'];
			   	$answer->email = $_POST['newEmail'];
			   	$answer->city = $_POST['newCity'];
			   	$answer->discount = $_POST['newDiscount'];
			   	$answer->discount_state = $_POST['newDiscountState'];
			   	$answer->charge = $_POST['newCharge'];
			   	$answer->discount_day = $_POST['newDiscountDay'];
			   	$answer->budget = $_POST['newBudget'];
			   	$answer->extra_fee = $_POST['newExtraFee'];
			   	$answer->budget_state = $_POST['newBudgetState'];
			   	$answer->bank = $_POST['newBank'];
			   	$answer->account_type = $_POST['newAccountType'];
			   	$answer->account_number = $_POST['newAccountNumber'];
			   	$answer->baloto_code = $_POST['newBalotoCode'];
			   	$answer->redeban_code = $_POST['newRedebanCode'];
			   	$answer->logo = $ruta;
			   	$answer->logo2 = $ruta2;
			   	$answer->link = $_POST['newLink'];
			   	$answer->message = $_POST['newMessage'];
	            $answer->first_id = $_POST['newFirstId'];
	            $answer->second_id = $_POST['newSecondId'];
	            $answer->third_id = $_POST['newThirdId'];
	            $answer->fourth_id = $_POST['newFourthId'];
	            $answer->fifth_id = $_POST['newFifthId'];
	            $answer->sixth_id = $_POST['newSixthId'];
	            $answer->seventh_id = $_POST['newSeventhId'];
	            $answer->eighth_id = $_POST['newEighthId'];
	            $answer->nineth_id = $_POST['newNinethId'];
	            $answer->tenth_id = $_POST['newTenthId'];
			   if ($answer->save()) {
			   	return redirect('unidades');
			   }
			 } else {
			 	return view('layouts.organizations_error');
			 }
		}

	}
	/*===================================
	=            USER EDIT            =
	===================================*/
	
	static public function ctrEditarUnidad(){

		if (isset($_POST['editOrganization'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"])) {
				$answer = adminph\Organization::find($_POST['editId']);
			   	/*======================================
			   	=            Validar Imagen             =
			   	======================================*/
			   		$ruta=$_POST['lastLogo'];
			   	if (isset($_FILES['logo']['tmp_name']) && !empty($_FILES['logo']['tmp_name'])) {
			   		list($ancho,$alto) = getimagesize($_FILES['logo']['tmp_name']);
			   		$nuevoAncho = 400;
			   		$nuevoAlto = 230;
			   		$nuevoAncho2 = 178;
			   		$nuevoAlto2 = 75;
			   		/*==========================================
			   		=            CREANDO DIRECTORIO            =
			   		==========================================*/
			   		$directorio = "Views/img/organizaciones/".$_POST['newCode'];
			   		if (!empty($_POST['lastLogo'])) {
			   			unlink($_POST['lastLogo']);
			   			unlink($answer->logo2);
			   		}else{
			   			mkdir($directorio,0755);
			   		}
			   		
			   		
			   		/*===========================================================================
			   		=            Funciones defecto PHP dependiendo de tipo de imagen            =
			   		===========================================================================*/
			   		switch ($_FILES['logo']['type']) {
			   			case 'image/jpeg':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newCode'].'_'.$preruta.'.jpg';
			   				$ruta2 = $directorio.'/'.$_POST['newCode'].'_'.$preruta.'2.jpg';
			   				$origen = imagecreatefromjpeg($_FILES['logo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				$destino2 = imagecreatetruecolor($nuevoAncho2, $nuevoAlto2);
			   				imagecopyresized($destino2, $origen, 0, 0, 0, 0, $nuevoAncho2, $nuevoAlto2, $ancho, $alto);
			   				imagejpeg($destino2,$ruta2);
			   				break;
			   			case 'image/png':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newCode'].'_'.$preruta.'.png';
			   				$ruta = $directorio.'/'.$_POST['newCode'].'_'.$preruta.'2.png';
			   				$origen = imagecreatefrompng($_FILES['logo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagepng($destino,$ruta);
			   				$destino2 = imagecreatetruecolor($nuevoAncho2, $nuevoAlto2);
			   				imagecopyresized($destino2, $origen, 0, 0, 0, 0, $nuevoAncho2, $nuevoAlto2, $ancho, $alto);
			   				imagepng($destino2,$ruta2);
			   				break;
			   			default:
			   				# code...
			   				break;
			   		}
			   		
			   		
			   	}
			   	$answer->name = $_POST['newName'];
			   	$answer->code = $_POST['newCode'];
			   	$answer->NIT = $_POST['newNIT'];
			   	$answer->address = $_POST['newAddress'];
			   	$answer->phone = $_POST['newPhone'];
			   	$answer->email = $_POST['newEmail'];
			   	$answer->city = $_POST['newCity'];
			   	$answer->discount = $_POST['newDiscount'];
			   	$answer->discount_state = $_POST['newDiscountState'];
			   	$answer->charge = $_POST['newCharge'];
			   	$answer->discount_day = $_POST['newDiscountDay'];
			   	$answer->budget = $_POST['newBudget'];
			   	$answer->extra_fee = $_POST['newExtraFee'];
			   	$answer->budget_state = $_POST['newBudgetState'];
			   	$answer->bank = $_POST['newBank'];
			   	$answer->account_type = $_POST['newAccountType'];
			   	$answer->account_number = $_POST['newAccountNumber'];
			   	$answer->baloto_code = $_POST['newBalotoCode'];
			   	$answer->redeban_code = $_POST['newRedebanCode'];
			   	$answer->logo = $ruta;
			   	$answer->logo2 = $ruta2;
			   	$answer->link = $_POST['newLink'];
			   	$answer->message = $_POST['newMessage'];
	            $answer->first_id = $_POST['newFirstId'];
	            $answer->second_id = $_POST['newSecondId'];
	            $answer->third_id = $_POST['newThirdId'];
	            $answer->fourth_id = $_POST['newFourthId'];
	            $answer->fifth_id = $_POST['newFifthId'];
	            $answer->sixth_id = $_POST['newSixthId'];
	            $answer->seventh_id = $_POST['newSeventhId'];
	            $answer->eighth_id = $_POST['newEighthId'];
	            $answer->nineth_id = $_POST['newNinethId'];
	            $answer->tenth_id = $_POST['newTenthId'];
			   if ($answer->save()) {
			   	return redirect('unidades');			   
			   }
			 } else {
			 	return view('layouts.organizations_error');
			 }
		}

	}
	/*======================================
	=            Borrar Unidad            =
	======================================*/
	static public function ctrBorrarUnidad(){
		if (isset($_POST['idUnidad'])) {
		$answer=adminph\Organization::find($_POST['idUnidad']);
			if ($_POST['fotoUnidad'] != "") {
				unlink($_POST["fotoUnidad"]);
				unlink($answer->logo2);
				rmdir('Views/img/organizaciones/'.$_POST['codigoUnidad']);
			}
		$answer->delete();
		}
	}
	public function ajaxEditarUnidad(){
		$answer = adminph\Organization::find($_POST['idUnidad']);
		echo json_encode($answer);
	} 
	public function ajaxCheckearUnidad(){
		$answer = adminph\Organization::where('code',$_POST['organizationCheck'])->first();
		echo json_encode($answer);
	} 
}