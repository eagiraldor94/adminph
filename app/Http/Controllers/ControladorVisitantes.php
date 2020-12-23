<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use SplFileInfo;
use adminph;
use Carbon\Carbon;

class ControladorVisitantes extends Controller
{
    /*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearVisitante(){
		if (isset($_POST['newGuest'])) {
			if (preg_match('/^[0-9\/ ]+$/', $_POST["newVisitDate"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\.\,\(\)\- ]+$/', $_POST["newObservations"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/', $_POST["newName"]) &&
				preg_match('/^[A-Z]+$/', $_POST["newIdType"]) &&
				preg_match('/^[a-zA-Z0-9\.\- ]+$/', $_POST["newIdNumber"])&&
				preg_match('/^[0-9\:\- ]+$/', $_POST["newStartHour"])&&
				preg_match('/^[0-9\:\- ]+$/', $_POST["newEndHour"])
			) {
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
			   	$answer = new adminph\Guest();
			   	$answer->organization_id = $user->property->organization->id;
			   	$answer->property_id = $user->property->id;
			   	$answer->auth_name = $user->name;
			   	$answer->name = $_POST['newName'];
			   	$answer->id_type = $_POST['newIdType'];
			   	$answer->id_number = $_POST['newIdNumber'];
			   	$answer->date = Carbon::parse($_POST['newVisitDate']);
			   	$answer->start_hour = $_POST['newStartHour'];
			   	$answer->end_hour = $_POST['newEndHour'];
			   	$answer->observations = $_POST['newObservations'];
			   if ($answer->save()) {
			   	return redirect('visitantes');
			   }
			 } else {
			 	return view('layouts.guests_error');
			 }
		}

	}
	/*======================================
	=            Borrar Boletin            =
	======================================*/
	static public function ctrBorrarVisitante(){
		if (isset($_POST['idVisitante'])) {
		if ($_POST['fotoVisitante'] != "") {
			unlink($_POST['fotoVisitante']);
		}
		if ($_POST['documentoVisitante'] != "") {
			unlink($_POST['documentoVisitante']);
		}
		$answer=adminph\Guest::find($_POST['idVisitante']);
		$answer->delete();
		}
	}
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatableVisitantes(){	
	if (session('rank')=='Admin') {
  		$productos = adminph\Guest::all();
	}elseif (session('rank')=='Vigilante' || session('rank')=='Concejo') {
		$answer = adminph\User::find(session('id'));
		$organization = adminph\Organization::where('code',$answer->code)->first();
		$productos = $organization->guests;
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
	       return redirect('/');
	      break;
	  }
		$productos = $answer->property->guests;
	}

  	echo '{
			"data": [';
			$buttons = "";
			for($i = 0; $i < count($productos)-1; $i++){
				/*=============================
				=            Stock            =
				=============================*/
				
	            if($productos[$i]->photo != "" && $productos[$i]->photo != null){
	            	$name="<a href='".$productos[$i]->photo."' target='_blank'><button class='btn btn-primary'>".$productos[$i]->name."</button></a>";
	            }else{
	            	$name=$productos[$i]->name;
	            }
	            if($productos[$i]->id_photo != "" && $productos[$i]->id_photo != null){
	            	$document="<a href='".$productos[$i]->id_photo."' target='_blank'><button class='btn btn-primary'>".$productos[$i]->id_number."</button></a>";
	            }else{
	            	$document=$productos[$i]->id_number;
	            }
				if ($productos[$i]->authorized == '1' || session('rank')=='Admin' || session('rank')=='Concejo') {
                    $buttons ="<div class='btn-group'></div>"; 
                }elseif (session('rank')=='Vigilante' && $productos[$i]->authorized == '0') {
                    $buttons ="<div class='btn-group'><button class='btn btn-success btnAutorizarIngreso' idVisitante='".$productos[$i]->id."' data-toggle='modal' data-target='#modalAutorizarIngreso'><i class='fas fa-user-check'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'><button class='btn btn-danger btnBorrarVisitante' idVisitante='".$productos[$i]->id."' fotoVisitante='".$productos[$i]->photo."' documentoVisitante='".$productos[$i]->photo."'><i class='fa fa-times'></i></button></div>";
                }
				 echo '[
			      "'.($i+1).'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->property->apartment.'",
			      "'.$name.'",
			      "'.$productos[$i]->id_type.'",
			      "'.$document.'",
			      "'.$productos[$i]->date.'",
			      "'.$productos[$i]->start_hour.'",
			      "'.$productos[$i]->end_hour.'",
			      "'.$productos[$i]->auth_name.'",
			      "'.$productos[$i]->authorizer.'",
			      "'.$productos[$i]->observations.'",
			      "'.$buttons.'"
			    ],';

			}
				/*=============================
				=            Stock            =
				=============================*/
				$buttons="";
	            if($productos[count($productos)-1]->photo != "" && $productos[count($productos)-1]->photo != null){
	            	$name="<a href='".$productos[count($productos)-1]->photo."' target='_blank'><button class='btn btn-primary'>".$productos[count($productos)-1]->name."</button></a>";
	            }else{
	            	$name=$productos[count($productos)-1]->name;
	            }
	            if($productos[count($productos)-1]->id_photo != "" && $productos[count($productos)-1]->id_photo != null){
	            	$document="<a href='".$productos[count($productos)-1]->id_photo."' target='_blank'><button class='btn btn-primary'>".$productos[count($productos)-1]->id_number."</button></a>";
	            }else{
	            	$document=$productos[count($productos)-1]->id_number;
	            }
				if ($productos[count($productos)-1]->authorized == '1' || session('rank')=='Admin' || session('rank')=='Concejo') {
                    $buttons ="<div class='btn-group'></div>"; 
                }elseif (session('rank')=='Vigilante' && $productos[count($productos)-1]->authorized == '0') {
                    $buttons ="<div class='btn-group'><button class='btn btn-success btnAutorizarIngreso' idVisitante='".$productos[count($productos)-1]->id."' data-toggle='modal' data-target='#modalAutorizarIngreso'><i class='fas fa-user-check'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'><button class='btn btn-danger btnBorrarVisitante' idVisitante='".$productos[count($productos)-1]->id."' fotoVisitante='".$productos[count($productos)-1]->photo."' documentoVisitante='".$productos[count($productos)-1]->photo."'><i class='fa fa-times'></i></button></div>";
                }
				 echo '[
			      "'.(count($productos)).'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->property->apartment.'",
			      "'.$name.'",
			      "'.$productos[count($productos)-1]->id_type.'",
			      "'.$document.'",
			      "'.$productos[count($productos)-1]->date.'",
			      "'.$productos[count($productos)-1]->start_hour.'",
			      "'.$productos[count($productos)-1]->end_hour.'",
			      "'.$productos[count($productos)-1]->auth_name.'",
			      "'.$productos[count($productos)-1]->authorizer.'",
			      "'.$productos[count($productos)-1]->observations.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
	static public function ctrAutorizarIngreso(){
		if (isset($_POST['newAuth'])) {
			$user = adminph\User::find(session('id'));
			$info =  "";
			$info2 =  "";
			if (isset($_FILES['photo']['name'])) {
				$info = new SplFileInfo($_FILES['photo']['name']);
				$info = $info->getExtension();
			}
			if (isset($_FILES['document']['name'])) {
				$info2 = new SplFileInfo($_FILES['document']['name']);
				$info2 = $info2->getExtension();
			}
		   	$ruta="";
		   	if (isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name']) && ($info == 'jpg' || $info == 'png' || $info == 'jpeg')) {
			   	$ruta = "Views/guests/";
			   	$ruta = $ruta . date('H-i-s_') . basename( $_FILES['photo']['name']) ;
			   	if(move_uploaded_file($_FILES['photo']['tmp_name'], $ruta)) {
			   	}else {
			   		$ruta = "";
			   	}
		   	}
		   	$ruta2="";
		   	if (isset($_FILES['document']['tmp_name']) && !empty($_FILES['document']['tmp_name']) && $info2 == 'pdf') {
			   	$ruta2 = "Views/guests/";
			   	$ruta2 = $ruta2 . date('H-i-s_') . basename( $_FILES['document']['name']) ;
			   	if(move_uploaded_file($_FILES['document']['tmp_name'], $ruta2)) {
			   	}else {
			   		$ruta2 = "";
			   	}
		   	}
			$answer=adminph\Guest::find($_POST['newAuthId']);
		   	$answer->authorized = 1;
		   	$answer->authorizer = $user->name;
		   	$answer->photo = $ruta;
		   	$answer->id_photo = $ruta2;
		   	if ($answer->save()) {
				return redirect('visitantes');
		   	}else{
			return redirect ('/');
			}
		}else{
			return redirect ('/');
		}
	}
}
