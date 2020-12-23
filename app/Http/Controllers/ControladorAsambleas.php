<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use adminph;

class ControladorAsambleas extends Controller
{
    /*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearAsamblea(){

		if (isset($_POST['newAssembly'])) {
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
			   	$answer = new adminph\Assembly();
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->subject = $_POST['newSubject'];
			   	$answer->body = $_POST['newBody'];
			   	$answer->link = $ruta;
			   	$answer->assembly_date = $_POST['newAssemblyDate'];
			   if ($answer->save()) {
			   	$mail = ControladorCorreos::ctrEnviarAsamblea($answer->id);
			   	return redirect('asambleas');
			   }
			 } else {
			 	return view('layouts.assemblys_error');
			 }
		}

	}
	/*===================================
	=            USER EDIT            =
	===================================*/
	
	static public function ctrEditarAsamblea(){

		if (isset($_POST['editAssembly'])) {
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
				$answer = adminph\Assembly::find($_POST['editId']);
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->subject = $_POST['newSubject'];
			   	$answer->body = $_POST['newBody'];
			   	$answer->link = $ruta;
			   	$answer->assembly_date = $_POST['newAssemblyDate'];
			   if ($answer->save()) {
			   	return redirect('asambleas');			   
			   }
			 } else {
			 	return view('layouts.assemblys_error');
			 }
		}

	}
	/*======================================
	=            Borrar Asamblea            =
	======================================*/
	static public function ctrBorrarAsamblea(){
		if (isset($_POST['idAsamblea'])) {
		if ($_POST['asamblea'] != "") {
			unlink($_POST['asamblea']);
		}
		$answer=adminph\Assembly::find($_POST['idAsamblea']);
		$answer->delete();
		}
	}
	public function ajaxEditarAsamblea(){
		$answer = adminph\Assembly::find($_POST['idAsamblea']);
		echo json_encode($answer);
	} 
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatableAsambleas()
	{	
	if (session('rank')=='Admin') {
  		$productos = adminph\Assembly::all();
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
	  $productos = adminph\Assembly::where('organization_id',$answer->organization_id)->get();
	}

  	echo '{
			"data": [';

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
                    $buttons ="<div class='btn-group'><button class='btn btn-warning btnEditarAsamblea' idAsamblea='".$productos[$i]->id."' data-toggle='modal' data-target='#modalEditarAsamblea'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarAsamblea' idAsamblea='".$productos[$i]->id."' asamblea='".$productos[$i]->link."'><i class='fa fa-times'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'><button class='btn btn-primary btnVerAsamblea' idAsamblea='".$productos[$i]->id."' data-toggle='modal' data-target='#modalVerAsamblea'><i class='fas fa-eye'></i></button></div>";
                }
				 echo '[
			      "'.($i+1).'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->subject.'",
			      "'.$document.'",
			      "'.$productos[$i]->assembly_date.'",
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
                    $buttons ="<div class='btn-group'><button class='btn btn-warning btnEditarAsamblea' idAsamblea='".$productos[count($productos)-1]->id."' data-toggle='modal' data-target='#modalEditarAsamblea'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarAsamblea' idAsamblea='".$productos[count($productos)-1]->id."' asamblea='".$productos[count($productos)-1]->link."'><i class='fa fa-times'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'><button class='btn btn-primary btnVerAsamblea' idAsamblea='".$productos[count($productos)-1]->id."' data-toggle='modal' data-target='#modalVerAsamblea'><i class='fas fa-eye'></i></button></div>";
                }
				 echo '[
			      "'.(count($productos)).'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->subject.'",
			      "'.$document.'",
			      "'.$productos[count($productos)-1]->assembly_date.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
}
