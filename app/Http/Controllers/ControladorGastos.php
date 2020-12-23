<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use SplFileInfo;
use adminph;
use Carbon\Carbon;

class ControladorGastos extends Controller
{
    /*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearGasto(){

		if (isset($_POST['newExpense'])) {
			$info = new SplFileInfo($_FILES['document']['name']);
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/', $_POST["newRefDocument"]) &&
				preg_match('/^[0-9\/ ]+$/', $_POST["newExpenseDate"]) &&
				preg_match('/^[0-9\.\,]+$/', $_POST["newAmount"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\.\,\(\)\- ]+$/', $_POST["newDescription"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/', $_POST["newName"]) &&
				preg_match('/^[A-Z]+$/', $_POST["newIdType"]) &&
				preg_match('/^[a-zA-Z0-9\.\- ]+$/', $_POST["newIdNumber"]) &&
				$info->getExtension() == 'pdf') {
			   	$ruta="";
			   	if (isset($_FILES['document']['tmp_name']) && !empty($_FILES['document']['tmp_name'])) {
				   	$ruta = "Views/expenses/";
				   	$ruta = $ruta . basename( $_FILES['document']['name']) ;
				   	if(move_uploaded_file($_FILES['document']['tmp_name'], $ruta)) {
				   	}else {
				   		$ruta = "";
				   	}
			   	}
			   	$answer = new adminph\Expense();
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->ref_document = $_POST['newRefDocument'];
			   	$answer->description = $_POST['newDescription'];
			   	$answer->amount = $_POST['newAmount'];
			   	$answer->name = $_POST['newName'];
			   	$answer->id_type = $_POST['newIdType'];
			   	$answer->id_number = $_POST['newIdNumber'];
			   	$answer->date = Carbon::parse($_POST['newExpenseDate']);
			   	$answer->link = $ruta;
			   if ($answer->save()) {
			   	$organization = adminph\Organization::find($_POST['newOrganizationId']);
			   	$organization->wallet -= $_POST['newAmount'];
			   	$organization->save();
			   	return redirect('gastos');
			   }
			 } else {
			 	return view('layouts.expenses_error');
			 }
		}

	}
	/*======================================
	=            Borrar Boletin            =
	======================================*/
	static public function ctrBorrarGasto(){
		if (isset($_POST['idGasto'])) {
		if ($_POST['gasto'] != "") {
			unlink($_POST['gasto']);
		}
		$answer=adminph\Expense::find($_POST['idGasto']);
		$organization = $answer->organization;
		$organization->wallet += $answer->amount;
		$answer->delete();
		$organization->save();
		}
	}
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatableGastos(){	
	if (session('rank')=='Admin') {
  		$productos = adminph\Expense::all();
	}else{
	  switch (session('rank')) {
	    case 'Encargado':
	      $answer = adminph\Attendant::find(session('id'));
	      $productos = adminph\Expense::where('organization_id',$answer->organization_id)->get();
	      break;
	    case 'Propietario':
	      $answer = adminph\Propietary::find(session('id'));
	      $productos = adminph\Expense::where('organization_id',$answer->organization_id)->get();
	      break;
	    case 'Arrendatario':
	      $answer = adminph\Lessee::find(session('id'));
	      $productos = adminph\Expense::where('organization_id',$answer->organization_id)->get();
	      break;
	    default:
	      $user = adminph\User::find(session('id'));
	      $answer = adminph\Organization::where('code',$user->code)->first();
	      $productos = adminph\Expense::where('organization_id',$answer->id)->get();
	      break;
	  }
	}

  	echo '{
			"data": [';
			$buttons = "";
			for($i = 0; $i < count($productos)-1; $i++){
				/*=============================
				=            Stock            =
				=============================*/
				
	            if($productos[$i]->link != "" && $productos[$i]->link != null){
	            	$document="<a href='".$productos[$i]->link."' target='_blank'><button class='btn btn-primary'>".$productos[$i]->ref_document."</button></a>";
	            }else{
	            	$document=$productos[$i]->ref_document;
	            }
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><button class='btn btn-danger btnBorrarGasto' idGasto='".$productos[$i]->id."' gasto='".$productos[$i]->link."'><i class='fa fa-times'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'><a href='".$productos[$i]->link."' target='_blank'><button class='btn btn-primary'><i class='fas fa-eye'></i></button></a></div>";
                }
				 echo '[
			      "'.($i+1).'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->description.'",
			      "'.$document.'",
			      "$ '.number_format($productos[$i]->amount,2).'",
			      "'.$productos[$i]->name.'",
			      "'.$productos[$i]->id_type.'",
			      "'.$productos[$i]->id_number.'",
			      "'.$productos[$i]->date.'",
			      "'.$buttons.'"
			    ],';

			}
				/*=============================
				=            Stock            =
				=============================*/
	            if($productos[count($productos)-1]->link != "" && $productos[count($productos)-1]->link != null){
	            	$document="<a href='".$productos[count($productos)-1]->link."' target='_blank'><button class='btn btn-primary'>".$productos[count($productos)-1]->ref_document."</button></a>";
	            }else{
	            	$document=$productos[count($productos)-1]->ref_document;
	            }
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><button class='btn btn-danger btnBorrarGasto' idGasto='".$productos[count($productos)-1]->id."' gasto='".$productos[count($productos)-1]->link."'><i class='fa fa-times'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'><a href='".$productos[count($productos)-1]->link."' target='_blank'><button class='btn btn-primary'><i class='fas fa-eye'></i></button></a></div>";
                }
				 echo '[
			      "'.(count($productos)).'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->description.'",
			      "'.$document.'",
			      "$ '.number_format($productos[count($productos)-1]->amount,2).'",
			      "'.$productos[count($productos)-1]->name.'",
			      "'.$productos[count($productos)-1]->id_type.'",
			      "'.$productos[count($productos)-1]->id_number.'",
			      "'.$productos[count($productos)-1]->date.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
}
