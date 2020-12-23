<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use SplFileInfo;
use adminph;

class ControladorReportes extends Controller
{
    /*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearReporte(){

		if (isset($_POST['newReport'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\.\,\(\)\- ]+$/', $_POST["newObservations"]) &&
				preg_match('/^[a-zA-Z]+$/', $_POST["newPriority"])
			) {
				$info = new SplFileInfo($_FILES['document']['name']);
				$info = $info->getExtension();
			   	$ruta="";
			   	if ($info=='pdf' || $info=='png' || $info=='jpg' || $info=='jpeg' ) {
			   	$ruta="";
				   	if (isset($_FILES['document']['tmp_name']) && !empty($_FILES['document']['tmp_name'])) {
					   	$ruta = "Views/reports/";
		   				$preruta = date('Y-m-d_his');
		   				$preruta = (string)$preruta;
					   	$ruta = $ruta . $preruta . basename( $_FILES['document']['name']) ;
					   	if(move_uploaded_file($_FILES['document']['tmp_name'], $ruta)) {
					   	}else {
					   		$ruta = "";
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
			   	$answer = new adminph\Report();
			   	$answer->organization_id = $organization->id;
			   	$answer->property_id = $property->id;
			   	$answer->priority = $_POST['newPriority'];
			   	$answer->observations = $_POST['newObservations'];
			   	$answer->name = $user->name;
			   	$answer->link = $ruta;
			   if ($answer->save()) {
			   	return redirect('reportes/daños');
			   }
			 } else {
			 	return view('layouts.damage_reports_error');
			 }
		}

	}
	/*======================================
	=            Borrar Boletin            =
	======================================*/
	static public function ctrBorrarReporte(){
		if (isset($_POST['idReporte'])) {
		if ($_POST['reporte'] != "") {
			unlink($_POST['reporte']);
		}
		$answer=adminph\Report::find($_POST['idReporte']);
		$answer->delete();
		}
	}
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatableReportes(){	
	if (session('rank')=='Admin') {
  		$productos = adminph\Report::all();
	}elseif (session('rank')=='Vigilante' || session('rank')=='Concejo') {
		$answer = adminph\User::find(session('id'));
		$organization = adminph\Organization::where('code',$answer->code)->first();
		$productos = $organization->reports;
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
	      break;
	  }
	  $property = $answer->property;
	  $productos = $property->reports;
	}

  	echo '{
			"data": [';
			$buttons = "<div></div>";
			$document = "<div></div>";
			$priority = "<div></div>";
			for($i = 0; $i < count($productos)-1; $i++){
				/*=============================
				=            Stock            =
				=============================*/
				
	            if($productos[$i]->link != "" && $productos[$i]->link != null){
	            	$document="<a href='".$productos[$i]->link."' target='_blank'><button class='btn btn-primary'>Ver evidencia</button></a>";
	            }else{
	            	$document="<div></div>";
	            }
	            switch ($productos[$i]->priority) {
	            	case 'Alta':
	            		$priority= "<div class='btn-group'><button class='btn btn-danger'>Alta</button></div>";
	            		break;

	            	case 'Media':
	            		$priority= "<div class='btn-group'><button class='btn btn-warning'>Media</button></div>";
	            		break;

	            	case 'Baja':
	            		$priority= "<div class='btn-group'><button class='btn btn-success'>Baja</button></div>";
	            		break;
	            	
	            	default:
	            		$priority= "<div></div>";
	            		break;
	            }
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><button class='btn btn-primary btnCambiarPrioridad' idReporte='".$productos[$i]->id."' data-toggle='modal' data-target='#modalCambiarPrioridad'><i class='fas fa-cog'></i></button><button class='btn btn-danger btnBorrarReporte' idReporte='".$productos[$i]->id."' reporte='".$productos[$i]->link."'><i class='fa fa-times'></i></button></div>";
                }elseif(session('rank')!='Vigilante' && session('rank')!='Concejo'){
                    $buttons ="<div class='btn-group'><button class='btn btn-danger btnBorrarReporte' idReporte='".$productos[$i]->id."' reporte='".$productos[$i]->link."'><i class='fa fa-times'></i></button></div>";
                }else{
                	$buttons="<div></div>";
                }
				 echo '[
			      "'.($i+1).'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->property->apartment.'",
			      "'.$priority.'",
			      "'.$productos[$i]->observations.'",
			      "'.$document.'",
			      "'.$productos[$i]->created_at.'",
			      "'.$productos[$i]->name.'",
			      "'.$buttons.'"
			    ],';

			}
				
	            if($productos[count($productos)-1]->link != "" && $productos[count($productos)-1]->link != null){
	            	$document="<a href='".$productos[count($productos)-1]->link."' target='_blank'><button class='btn btn-primary'>Ver evidencia</button></a>";
	            }else{
	            	$document="<div></div>";
	            }
	            switch ($productos[count($productos)-1]->priority) {
	            	case 'Alta':
	            		$priority= "<div class='btn-group'><button class='btn btn-danger'>Alta</button></div>";
	            		break;

	            	case 'Media':
	            		$priority= "<div class='btn-group'><button class='btn btn-warning'>Media</button></div>";
	            		break;

	            	case 'Baja':
	            		$priority= "<div class='btn-group'><button class='btn btn-success'>Baja</button></div>";
	            		break;
	            	
	            	default:
	            		$priority= "<div></div>";
	            		break;
	            }
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><button class='btn btn-primary btnCambiarPrioridad' idReporte='".$productos[count($productos)-1]->id."' data-toggle='modal' data-target='#modalCambiarPrioridad'><i class='fas fa-cog'></i></button><button class='btn btn-danger btnBorrarReporte' idReporte='".$productos[count($productos)-1]->id."' reporte='".$productos[count($productos)-1]->link."'><i class='fa fa-times'></i></button></div>";
                }elseif(session('rank')!='Vigilante' && session('rank')!='Concejo'){
                    $buttons ="<div class='btn-group'><button class='btn btn-danger btnBorrarReporte' idReporte='".$productos[count($productos)-1]->id."' reporte='".$productos[count($productos)-1]->link."'><i class='fa fa-times'></i></button></div>";
                }else{
                	$buttons="<div></div>";
                }
				 echo '[
			      "'.(count($productos)).'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->property->apartment.'",
			      "'.$priority.'",
			      "'.$productos[count($productos)-1]->observations.'",
			      "'.$document.'",
			      "'.$productos[count($productos)-1]->created_at.'",
			      "'.$productos[count($productos)-1]->name.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
	static public function ctrCambiarPrioridad(){
		if (isset($_POST['newPriority'])) {
			$answer=adminph\Report::find($_POST['newAuthId']);
		   	$answer->priority = $_POST['newPriorityChange'];
			$answer->save();
			return redirect('reportes-danos');
		}
	}
}
