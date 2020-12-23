<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use adminph;

class ControladorPropiedades extends Controller
{
    
    /*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearPropiedad(){

		if (isset($_POST['newProperty'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ -_]+$/', $_POST["newApartment"])) {
			   	$answer = new adminph\Property();
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$organization=adminph\Organization::find($_POST['newOrganizationId']);
			   	$organization->propertys->add($answer);
			   	$answer->apartment = $_POST['newApartment'];
			   	$answer->apartment_coefficient = $_POST['newApartmentCoefficient'];
			   	$answer->parking = $_POST['newParking'];
			   	$answer->parking_coefficient = $_POST['newParkingCoefficient'];
			   	$answer->useful_room = $_POST['newUsefulRoom'];
			   	$answer->useful_room_coefficient = $_POST['newUsefulRoomCoefficient'];
			   	$answer->plates = $_POST['newPlates'];
			   	$answer->pets = $_POST['newPets'];
			   	$answer->extra_fee_state = $_POST['newExtraFeeState'];
			   	$answer->bill_state = $_POST['newBillState'];
			   	$answer->fixed_fee = $_POST['newFixedFee'];
			   if ($answer->save()) {
			   	return redirect('propiedades');
			   }
			 } else {
			 	return view('layouts.propertys_error');
			 }
		}

	}
	/*===================================
	=            USER EDIT            =
	===================================*/
	
	static public function ctrEditarPropiedad(){

		if (isset($_POST['editProperty'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ -_]+$/', $_POST["newApartment"])) {
				$answer = adminph\Property::find($_POST['editId']);
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$organization=adminph\Organization::find($_POST['newOrganizationId']);
			   	$organization->property()->associate($answer);
			   	$answer->apartment = $_POST['newApartment'];
			   	$answer->apartment_coefficient = $_POST['newApartmentCoefficient'];
			   	$answer->parking = $_POST['newParking'];
			   	$answer->parking_coefficient = $_POST['newParkingCoefficient'];
			   	$answer->useful_room = $_POST['newUsefulRoom'];
			   	$answer->useful_room_coefficient = $_POST['newUsefulRoomCoefficient'];
			   	$answer->plates = $_POST['newPlates'];
			   	$answer->pets = $_POST['newPets'];
			   	$answer->extra_fee_state = $_POST['newExtraFeeState'];
			   	$answer->bill_state = $_POST['newBillState'];
			   	$answer->fixed_fee = $_POST['newFixedFee'];
			   if ($answer->save()) {
			   	return redirect('propiedades');			   
			   }
			 } else {
			 	return view('layouts.propertys_error');
			 }
		}

	}
	/*======================================
	=            Borrar Propiedad            =
	======================================*/
	static public function ctrBorrarPropiedad(){
		if (isset($_POST['idPropiedad'])) {
		$answer=adminph\Property::find($_POST['idPropiedad']);
		$answer->delete();
		}
	}
	public function ajaxEditarPropiedad(){
		$answer = adminph\Property::find($_POST['idPropiedad']);
		echo json_encode($answer);
	} 
	public function ajaxConsultarPropiedades(){
		$answer = adminph\Property::where('organization_id',$_POST['idUnidad'])->get();
		echo json_encode($answer);
	} 
	public function ajaxCheckearPropiedad(){
		$answer = adminph\Property::where('apartment',$_POST['numeroPropiedad'])->where('organization_id',$_POST['idUnidad'])->first();
		echo json_encode($answer);
	} 
	/*======================================
	=           Subir propiedades          =
	======================================*/
	static public function ctrSubirPropiedades(){
		$handle = fopen($_FILES['propiedades']['tmp_name'], "r");

		while ($csvLine = fgetcsv($handle, 1000, ";")) {
				$csvLine = array_map("utf8_encode", $csvLine); //added
			   	$organization = adminph\Organization::where('code',$csvLine[0])->first();
				if (is_object($organization)) {

				   	$answer = new adminph\Property();
				   	$answer->organization_id = $organization->id;
				   	$answer->apartment = $csvLine[1];
				   	$answer->apartment_coefficient = $csvLine[2];
				   	$answer->parking = $csvLine[3];
				   	$answer->parking_coefficient = $csvLine[4];
				   	$answer->useful_room = $csvLine[5];
				   	$answer->useful_room_coefficient = $csvLine[6];
				   	$answer->plates = $csvLine[7];
				   	$answer->pets = $csvLine[8];
				   	$answer->extra_fee_state = $csvLine[9];
				   	$answer->bill_state = $csvLine[10];
				   	$answer->fixed_fee = $csvLine[11];
				   	$answer->first_balance = $csvLine[12];
				   	$answer->second_balance = $csvLine[13];
				   	$answer->third_balance = $csvLine[14];
				   	$answer->fourth_balance = $csvLine[15];
				   	$answer->fifth_balance = $csvLine[16];
				   	$answer->sixth_balance = $csvLine[17];
				   	$answer->seventh_balance = $csvLine[18];
				   	$answer->eighth_balance = $csvLine[19];
				   	$answer->nineth_balance = $csvLine[20];
				   	$answer->tenth_balance = $csvLine[21];
				    $answer->save();
		    	}
		}
		
	   	return redirect('propiedades');

	}
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatablePropiedades()
	{	
  	$productos = adminph\Property::all();
  	echo '{
			"data": [';

			for($i = 0; $i < count($productos)-1; $i++){
				/*=============================
				=            Stock            =
				=============================*/
				
	            if($productos[$i]->extra_fee_state == 1){
	            	$extraFeeState="<td><button class='btn btn-success btn-sm'>Activado</button></td>";
	            }else{
	            	$extraFeeState="<td><button class='btn btn-danger btn-sm'>Desactivado</button></td>";
	            }
	            if($productos[$i]->bill_state == 1){
	            	$billState="<td><button class='btn btn-success btn-sm'>Activado</button></td>";
	            }else{
	            	$billState="<td><button class='btn btn-danger btn-sm'>Desactivado</button></td>";
	            }
                    $buttons ="<div class='btn-group'><form name='".$productos[$i]->id."' method='post' target='_blank' action='facturas'><input type='hidden' name='idPropiedad' value='".$productos[$i]->id."'><input type='hidden' name='_token' value='".csrf_token()."'><button class='btn btn-primary btnImprimirFactura' idPropiedad='".$productos[$i]->id."'><i class='fas fa-file-pdf'></i></button></form><button class='btn btn-warning btnEditarPropiedad' idPropiedad='".$productos[$i]->id."' data-toggle='modal' data-target='#modalEditarPropiedad'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarPropiedad' idPropiedad='".$productos[$i]->id."'><i class='fa fa-times'></i></button></div>";
				 echo '[
			      "'.($i+1).'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->apartment.'",
			      "'.$productos[$i]->apartment_coefficient.'",
			      "'.$productos[$i]->parking.'",
			      "'.$productos[$i]->parking_coefficient.'",
			      "'.$productos[$i]->useful_room.'",
			      "'.$productos[$i]->useful_room_coefficient.'",
			      "'.$extraFeeState.'",
			      "'.$billState.'",
			      "'.$productos[$i]->fixed_fee.'",
			      "'.$buttons.'"
			    ],';

			}
				
	            if($productos[count($productos)-1]->extra_fee_state == 1){
	            	$extraFeeState="<td><button class='btn btn-success btn-sm'>Activado</button></td>";
	            }else{
	            	$extraFeeState="<td><button class='btn btn-danger btn-sm'>Desactivado</button></td>";
	            }
	            if($productos[count($productos)-1]->bill_state == 1){
	            	$billState="<td><button class='btn btn-success btn-sm'>Activado</button></td>";
	            }else{
	            	$billState="<td><button class='btn btn-danger btn-sm'>Desactivado</button></td>";
	            }
                    $buttons ="<div class='btn-group'><form name='".$productos[count($productos)-1]->id."' method='post' target='_blank' action='facturas'><input type='hidden' name='idPropiedad' value='".$productos[count($productos)-1]->id."'><input type='hidden' name='_token' value='".csrf_token()."'><button class='btn btn-primary btnImprimirFactura' idPropiedad='".$productos[count($productos)-1]->id."'><i class='fas fa-file-pdf'></i></button></form><button class='btn btn-warning btnEditarPropiedad' idPropiedad='".$productos[count($productos)-1]->id."' data-toggle='modal' data-target='#modalEditarPropiedad'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarPropiedad' idPropiedad='".$productos[count($productos)-1]->id."'><i class='fa fa-times'></i></button></div>";
				 echo '[
			      "'.count($productos).'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->apartment.'",
			      "'.$productos[count($productos)-1]->apartment_coefficient.'",
			      "'.$productos[count($productos)-1]->parking.'",
			      "'.$productos[count($productos)-1]->parking_coefficient.'",
			      "'.$productos[count($productos)-1]->useful_room.'",
			      "'.$productos[count($productos)-1]->useful_room_coefficient.'",
			      "'.$extraFeeState.'",
			      "'.$billState.'",
			      "'.$productos[count($productos)-1]->fixed_fee.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
}
