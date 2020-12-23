<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use adminph;

class ControladorBoletines extends Controller
{
    /*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearBoletin(){

		if (isset($_POST['newBulletin'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newSubject"])) {
			   	$ruta="";
			   	if (isset($_FILES['document']['tmp_name']) && !empty($_FILES['document']['tmp_name'])) {
				   	$ruta = "Views/documents/";
				   	$ruta = $ruta . basename( $_FILES['document']['name']) ;
				   	if(move_uploaded_file($_FILES['document']['tmp_name'], $ruta)) {
				   	}else {
				   		$ruta = "";
				   	}
			   	}
			   	$answer = new adminph\Bulletin();
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->subject = $_POST['newSubject'];
			   	$answer->body = $_POST['newBody'];
			   	$answer->link = $ruta;
			   if ($answer->save()) {
			   	$mail = ControladorCorreos::ctrEnviarBoletin($answer->id);
			   	return redirect('boletines');
			   }
			 } else {
			 	return view('layouts.bulletins_error');
			 }
		}

	}
	/*===================================
	=            USER EDIT            =
	===================================*/
	
	static public function ctrEditarBoletin(){

		if (isset($_POST['editBulletin'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newSubject"])) {
			   	$ruta=$_POST['lastDocument'];
			   	if (isset($_FILES['document']['tmp_name']) && !empty($_FILES['document']['tmp_name'])) {
				   	$ruta = "Views/documents/";
				   	$ruta = $ruta . basename( $_FILES['document']['name']) ;
				   	if(move_uploaded_file($_FILES['document']['tmp_name'], $ruta)) {
				   	}else {
				   		$ruta = $_POST['lastDocument'];
				   	}
			   	}
				$answer = adminph\Bulletin::find($_POST['editId']);
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->subject = $_POST['newSubject'];
			   	$answer->body = $_POST['newBody'];
			   	$answer->link = $ruta;
			   if ($answer->save()) {
			   	return redirect('boletines');			   
			   }
			 } else {
			 	return view('layouts.bulletins_error');
			 }
		}

	}
	/*======================================
	=            Borrar Boletin            =
	======================================*/
	static public function ctrBorrarBoletin(){
		if (isset($_POST['idBoletin'])) {
		if ($_POST['boletin'] != "") {
			unlink($_POST['boletin']);
		}
		$answer=adminph\Bulletin::find($_POST['idBoletin']);
		$answer->delete();
		}
	}
	public function ajaxEditarBoletin(){
		$answer = adminph\Bulletin::find($_POST['idBoletin']);
		echo json_encode($answer);
	} 
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatableBoletines(){	
	if (session('rank')=='Admin') {
  		$productos = adminph\Bulletin::all();
	}else{
	  switch (session('rank')) {
	    case 'Encargado':
	      $answer = adminph\Attendant::find(session('id'));
	      break;
	    case 'Propietario':
	      $answer = adminph\Propietary::find(session('id'));
	      break;
	    case 'Arrendatario':
	      $answer = adminph\Lessee::find(session('id'));
	      break;
	    default:
	      $answer = adminph\User::find(session('id'));
	      break;
	  }
	  $productos = adminph\Bulletin::where('organization_id',$answer->organization_id)->get();
	}

  	echo '{
			"data": [';
			$buttons = "";
			for($i = 0; $i < count($productos)-1; $i++){
				/*=============================
				=            Stock            =
				=============================*/
				
	            if($productos[$i]->link != "" && $productos[$i]->link != null){
	            	$document="<td><a href='".$productos[$i]->link."' target='_blank'><button class='btn btn-primary'>Ver documento</button></a></td>";
	            }else{
	            	$document="<td>No hay adjunto</td>";
	            }
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><button class='btn btn-warning btnEditarBoletin' idBoletin='".$productos[$i]->id."' data-toggle='modal' data-target='#modalEditarBoletin'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarBoletin' idBoletin='".$productos[$i]->id."' boletin='".$productos[$i]->link."'><i class='fa fa-times'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'><button class='btn btn-primary btnVerBoletin' idBoletin='".$productos[$i]->id."' data-toggle='modal' data-target='#modalVerBoletin'><i class='fas fa-eye'></i></button></div>";
                }
				 echo '[
			      "'.($i+1).'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->subject.'",
			      "'.$document.'",
			      "'.$buttons.'"
			    ],';

			}
				/*=============================
				=            Stock            =
				=============================*/
				
	            if($productos[count($productos)-1]->link != "" && $productos[count($productos)-1]->link != null){
	            	$document="<td><a href='".$productos[count($productos)-1]->link."' target='_blank'><button class='btn btn-primary'>Ver documento</button></a></td>";
	            }else{
	            	$document="<td>No hay adjunto</td>";
	            }
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><button class='btn btn-warning btnEditarBoletin' idBoletin='".$productos[count($productos)-1]->id."' data-toggle='modal' data-target='#modalEditarBoletin'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarBoletin' idBoletin='".$productos[count($productos)-1]->id."' boletin='".$productos[count($productos)-1]->link."'><i class='fa fa-times'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'><button class='btn btn-primary btnVerBoletin' idBoletin='".$productos[count($productos)-1]->id."' data-toggle='modal' data-target='#modalVerBoletin'><i class='fas fa-eye'></i></button></div>";
                }
				 echo '[
			      "'.(count($productos)).'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->subject.'",
			      "'.$document.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
}
