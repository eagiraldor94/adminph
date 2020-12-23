<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use SplFileInfo;
use adminph;

class ControladorPaquetes extends Controller
{
    /*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearCorrespondencia(){
		if (isset($_POST['newPackage'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\.\,\(\)\- ]+$/', $_POST["newObservations"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/', $_POST["newName"]) &&
				preg_match('/^[A-Z]+$/', $_POST["newIdType"]) &&
				preg_match('/^[a-zA-Z0-9\.\- ]+$/', $_POST["newIdNumber"])
			) {
				$user = adminph\User::find(session('id'));
				$info =  "";
				if (isset($_FILES['photo']['tmp_name'])) {
					$info = new SplFileInfo($_FILES['photo']['tmp_name']);
					$info = $info->getExtension();
				}
			   	$ruta="";
			   	if (isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name']) && ($info == 'jpg' || $info == 'png' || $info == 'jpeg')) {
				   	$ruta = "Views/packages/";
				   	$ruta = $ruta . date('H-i-s_') . basename( $_FILES['photo']['name']) ;
				   	if(move_uploaded_file($_FILES['photo']['tmp_name'], $ruta)) {
				   	}else {
				   		$ruta = "";
				   	}
			   	}
			   	$answer = new adminph\Package();
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->property_id = $_POST['newPropertyId'];
			   	$answer->receiver = $user->name;
			   	$answer->name = $_POST['newName'];
			   	$answer->id_type = $_POST['newIdType'];
			   	$answer->id_number = $_POST['newIdNumber'];
			   	$answer->photo = $ruta;
			   	$answer->observations = $_POST['newObservations'];
			   if ($answer->save()) {
			   	return redirect('correspondencia');
			   }
			 } else {
			 	return view('layouts.package_error');
			 }
		}

	}
	/*======================================
	=            Borrar Boletin            =
	======================================*/
	static public function ctrBorrarCorrespondencia(){
		if (isset($_POST['idCorrespondencia'])) {
		if ($_POST['fotoCorrespondencia'] != "") {
			unlink($_POST['fotoCorrespondencia']);
		}
		$answer=adminph\Package::find($_POST['idCorrespondencia']);
		$answer->delete();
		}
	}
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatableCorrespondencia(){	
	if (session('rank')=='Admin') {
  		$productos = adminph\Package::all();
	}elseif (session('rank')=='Vigilante' || session('rank')=='Concejo') {
		$answer = adminph\User::find(session('id'));
		$organization = adminph\Organization::where('code',$answer->code)->first();
		$productos = $organization->packages;
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
	$productos = $answer->property->packages;
	}

  	echo '{
			"data": [';
			$buttons = "";
			for($i = 0; $i < count($productos)-1; $i++){
				/*=============================
				=            Stock            =
				=============================*/
				
	            if($productos[$i]->photo != "" && $productos[$i]->photo != null){
	            	$photo="<a href='".$productos[$i]->photo."' target='_blank'><img src='".$productos[$i]->photo."' class='img-thumbnail' width='40px'></a>";
	            }else{
	            	$photo="";
	            }
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><button class='btn btn-danger btnBorrarCorrespondencia' idCorrespondencia='".$productos[$i]->id."' fotoCorrespondencia='".$productos[$i]->photo."'><i class='fa fa-times'></i></button></div>"; 
                }elseif (session('rank')=='Vigilante') {
                    $buttons ="<div class='btn-group'><button class='btn btn-success btnEntregarCorrespondencia' idCorrespondencia='".$productos[$i]->id."' data-toggle='modal' data-target='#modalEntregarCorrespondencia'><i class='fas fa-box-open'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'></div>";
                }
				 echo '[
			      "'.($i+1).'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->property->apartment.'",
			      "'.$photo.'",
			      "'.$productos[$i]->name.'",
			      "'.$productos[$i]->id_type.'",
			      "'.$productos[$i]->id_number.'",
			      "'.$productos[$i]->receiver.'",
			      "'.$productos[$i]->claimer.'",
			      "'.$productos[$i]->claimer_id_type.'",
			      "'.$productos[$i]->claimer_id_number.'",
			      "'.$productos[$i]->delieverer.'",
			      "'.$productos[$i]->deliever_date.'",
			      "'.$productos[$i]->observations.'",
			      "'.$productos[$i]->created_at.'",
			      "'.$productos[$i]->updated_at.'",
			      "'.$buttons.'"
			    ],';

			}
				/*=============================
				=            Stock            =
				=============================*/
	            if($productos[count($productos)-1]->photo != "" && $productos[count($productos)-1]->photo != null){
	            	$photo="<a href='".$productos[count($productos)-1]->photo."' target='_blank'><img src='".$productos[count($productos)-1]->photo."' class='img-thumbnail' width='40px'></a>";
	            }else{
	            	$photo="";
	            }
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><button class='btn btn-danger btnBorrarCorrespondencia' idCorrespondencia='".$productos[count($productos)-1]->id."' fotoCorrespondencia='".$productos[count($productos)-1]->photo."'><i class='fa fa-times'></i></button></div>"; 
                }elseif (session('rank')=='Vigilante') {
                    $buttons ="<div class='btn-group'><button class='btn btn-success btnEntregarCorrespondencia' idCorrespondencia='".$productos[count($productos)-1]->id."' data-toggle='modal' data-target='#modalEntregarCorrespondencia'><i class='fas fa-box-open'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'></div>";
                }
				 echo '[
			      "'.(count($productos)).'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->property->apartment.'",
			      "'.$photo.'",
			      "'.$productos[count($productos)-1]->name.'",
			      "'.$productos[count($productos)-1]->id_type.'",
			      "'.$productos[count($productos)-1]->id_number.'",
			      "'.$productos[count($productos)-1]->receiver.'",
			      "'.$productos[count($productos)-1]->claimer.'",
			      "'.$productos[count($productos)-1]->claimer_id_type.'",
			      "'.$productos[count($productos)-1]->claimer_id_number.'",
			      "'.$productos[count($productos)-1]->delieverer.'",
			      "'.$productos[count($productos)-1]->deliever_date.'",
			      "'.$productos[count($productos)-1]->observations.'",
			      "'.$productos[count($productos)-1]->created_at.'",
			      "'.$productos[count($productos)-1]->updated_at.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
	static public function ctrEntregarCorrespondencia(){
		if (isset($_POST['newAuth'])) {
			$user = adminph\User::find(session('id'));
			$answer=adminph\Package::find($_POST['newAuthId']);
		   	$answer->claimer = $_POST['newName'];
		   	$answer->claimer_id_type = $_POST['newClaimerIdType'];
		   	$answer->claimer_id_number = $_POST['newClaimerIdNumber'];
		   	$answer->delieverer = $user->name;
		   	$answer->deliever_date = date('Y-m-d H:i:s');
			$answer->save();
			return redirect('correspondencia');
		}
	}
}
