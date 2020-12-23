<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use SplFileInfo;
use adminph;

class ControladorMinutas extends Controller
{
    /*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearMinuta(){

		if (isset($_POST['newMinute'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ]+$/', $_POST["newType"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\.\,\(\)\- ]+$/', $_POST["newObservations"])
			) {
				$info = new SplFileInfo($_FILES['document']['name']);
				$info = $info->getExtension();
			   	$ruta="";
			   	if ($info=='pdf' || $info=='png' || $info=='jpg' || $info=='jpeg' ) {
				   	if (isset($_FILES['document']['tmp_name']) && !empty($_FILES['document']['tmp_name'])) {
					   	$ruta = "Views/minutes/";
					   	$ruta = $ruta . basename( $_FILES['document']['name']) ;
					   	if(move_uploaded_file($_FILES['document']['tmp_name'], $ruta)) {
					   	}else {
					   		$ruta = "";
					   	}
				   	}
			   	}
			   	$user = adminph\User::find(session('id'));
			   	$organization = adminph\Organization::where('code',$user->code)->first();
			   	$answer = new adminph\Minute();
			   	$answer->organization_id = $organization->id;
			   	$answer->user_id =  $user->id;
			   	$answer->type = $_POST['newType'];
			   	$answer->observations = $_POST['newObservations'];
			   	$answer->link = $ruta;
			   if ($answer->save()) {
			   	return view('layouts.minutes');
			   }
			 } else {
			 	return view('layouts.minutes_error');
			 }
		}

	}
	/*======================================
	=            Borrar Boletin            =
	======================================*/
	static public function ctrBorrarMinuta(){
		if (isset($_POST['idMinuta'])) {
		if ($_POST['minuta'] != "") {
			unlink($_POST['minuta']);
		}
		$answer=adminph\Minute::find($_POST['idMinuta']);
		$answer->delete();
		}
	}
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatableMinutas(){	
	if (session('rank')=='Admin') {
  		$productos = adminph\Minute::all();
	}elseif(session('rank')=='Vigilante'){
	  $answer = adminph\User::find(session('id'));
	  $organization = adminph\Organization::where('code',$answer->code)->first();
	  $productos = adminph\Minute::where('organization_id',$organization->id)->get();
	}

  	echo '{
			"data": [';
			$buttons = "";
			for($i = 0; $i < count($productos)-1; $i++){
				/*=============================
				=            Stock            =
				=============================*/
				
	            if($productos[$i]->link != "" && $productos[$i]->link != null){
	            	$document="<a href='".$productos[$i]->link."' target='_blank'><button class='btn btn-primary'>Ver documento</button></a>";
	            }else{
	            	$document="";
	            }
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><button class='btn btn-danger btnBorrarMinuta' idMinuta='".$productos[$i]->id."' minuta='".$productos[$i]->link."'><i class='fa fa-times'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'></div>";
                }
				 echo '[
			      "'.($i+1).'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->type.'",
			      "'.$productos[$i]->observations.'",
			      "'.$document.'",
			      "'.$productos[$i]->created_at.'",
			      "'.$productos[$i]->user->name.'",
			      "'.$buttons.'"
			    ],';

			}
				/*=============================
				=            Stock            =
				=============================*/
				
	            if($productos[count($productos)-1]->link != "" && $productos[count($productos)-1]->link != null){
	            	$document="<a href='".$productos[count($productos)-1]->link."' target='_blank'><button class='btn btn-primary'>Ver documento</button></a>";
	            }else{
	            	$document="";
	            }
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><button class='btn btn-danger btnBorrarMinuta' idMinuta='".$productos[count($productos)-1]->id."' minuta='".$productos[count($productos)-1]->link."'><i class='fa fa-times'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'></div>";
                }
				 echo '[
			      "'.(count($productos)).'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->type.'",
			      "'.$productos[count($productos)-1]->observations.'",
			      "'.$document.'",
			      "'.$productos[count($productos)-1]->created_at.'",
			      "'.$productos[count($productos)-1]->user->name.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
}
