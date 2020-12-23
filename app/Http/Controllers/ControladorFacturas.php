<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use adminph;

class ControladorFacturas extends Controller
{

    /*==========================       =
	===================================*/
	
	static public function ctrCrearFactura(){

		if (isset($_POST['idPropiedad'])){
			$property = adminph\Property::find($_POST['idPropiedad']);
			$organization = $property->organization;
		   	date_default_timezone_set('America/Bogota');
		   	$month = date('m');
		   	$year = date('Y');
			$bill = adminph\Bill::where('property_id',$property->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->first();
			if ($bill==null || $bill=="") {
				$admon = adminph\Concept::where('name','Cuota ordinaria')->first();
				$extra = adminph\Concept::where('name','Cuota extra')->first();
				$charge = adminph\Concept::where('name','Interes')->first();
			   	$notaCredito = adminph\Concept::where('name','Nota credito')->first();
				if ($organization->budget_state==1) {
					$coeff = $property->apartment_coefficient + $property->parking_coefficient + $property->useful_room_coefficient;
					$admonFee = $coeff/100*$organization->budget;
				}else{
					$admonFee = $property->fixed_fee;
				}
				$admonDoc = new adminph\Document();
				$admonDoc->concept_id = $admon->id;
				$admonDoc->property_id = $property->id;
				$admonDoc->organization_id = $organization->id;
				$admonDoc->date = date('Y-m-d');
				$admonDoc->body = "cuota ordinaria correspondiente al mes ".date('m/Y');
				$admonDoc->amount = $admonFee;
				$lastDoc = adminph\Document::where('concept_id',$admon->id)->where('organization_id',$organization->id)->orderBy('number','desc')->first();
				if ($lastDoc != null && $lastDoc != "") {
					$docNumber=$lastDoc->number+1;
				}else{
					$docNumber=1;
				}
				$admonDoc->number = $docNumber;
				$admonDoc->save();
				if ($property->extra_fee_state==1) {
					$coeff = $property->apartment_coefficient + $property->parking_coefficient + $property->useful_room_coefficient;
					$extraFee = $coeff/100*$organization->extra_fee;
				}else{
					$extraFee = 0;
				}
				$extraDoc = new adminph\Document();
				$extraDoc->concept_id = $extra->id;
				$extraDoc->property_id = $property->id;
				$extraDoc->organization_id = $organization->id;
				$extraDoc->date = date('Y-m-d');
				$extraDoc->body = "cuota extra correspondiente al mes ".date('m/Y');
				$extraDoc->amount = $extraFee;
				$lastDoc = adminph\Document::where('concept_id',$extra->id)->where('organization_id',$organization->id)->orderBy('number','desc')->first();
				if ($lastDoc != null && $lastDoc != "") {
					$docNumber=$lastDoc->number+1;
				}else{
					$docNumber=1;
				}
				$extraDoc->number = $docNumber;
				$extraDoc->save();
				$balance = 0;
				$balance2 = 0;
				$billTemp = array();
				if ($notaCredito->id==$organization->first_id) {
					$balance -= $property->first_balance;
					$balance2 -= $property->first_balance;
					$billTemp['first_balance'] = $property->first_balance;
				}elseif ($charge->id==$organization->first_id) {
					$balance2 += $property->first_balance;
					$billTemp['first_balance'] = $property->first_balance;
				}else{
					$balance2 += $property->first_balance;
					$balance += $property->first_balance;
					$billTemp['first_balance'] = $property->first_balance;
				}
				if ($notaCredito->id==$organization->second_id) {
					$balance -= $property->second_balance;
					$balance2 -= $property->second_balance;
					$billTemp['second_balance'] = $property->second_balance;
				}elseif ($charge->id==$organization->second_id) {
					$balance2 += $property->second_balance;
					$billTemp['second_balance'] = $property->second_balance;
				}else{
					$balance += $property->second_balance;
					$balance2 += $property->second_balance;
					$billTemp['second_balance'] = $property->second_balance;
				}
				if ($notaCredito->id==$organization->third_id) {
					$balance -= $property->third_balance;
					$balance2 -= $property->third_balance;
					$billTemp['third_balance'] = $property->third_balance;
				}elseif ($charge->id==$organization->third_id) {
					$balance2 += $property->third_balance;
					$billTemp['third_balance'] = $property->third_balance;
				}else{
					$balance2 += $property->third_balance;
					$balance += $property->third_balance;
					$billTemp['third_balance'] = $property->third_balance;
				}
				if ($notaCredito->id==$organization->fourth_id) {
					$balance -= $property->fourth_balance;
					$balance2 -= $property->fourth_balance;
					$billTemp['fourth_balance'] = $property->fourth_balance;
				}elseif ($charge->id==$organization->fourth_id) {
					$balance2 += $property->fourth_balance;
					$billTemp['fourth_balance'] = $property->fourth_balance;
				}else{
					$balance += $property->fourth_balance;
					$balance2 += $property->fourth_balance;
					$billTemp['fourth_balance'] = $property->fourth_balance;
				}
				if ($notaCredito->id==$organization->fifth_id) {
					$balance -= $property->fifth_balance;
					$balance2 -= $property->fifth_balance;
					$billTemp['fifth_balance'] = $property->fifth_balance;
				}elseif ($charge->id==$organization->fifth_id) {
					$balance2 += $property->fifth_balance;
					$billTemp['fifth_balance'] = $property->fifth_balance;
				}else{
					$balance += $property->fifth_balance;
					$balance2 += $property->fifth_balance;
					$billTemp['fifth_balance'] = $property->fifth_balance;
				}
				if ($notaCredito->id==$organization->sixth_id) {
					$balance -= $property->sixth_balance;
					$balance2 -= $property->sixth_balance;
					$billTemp['sixth_balance'] = $property->sixth_balance;
				}elseif ($charge->id==$organization->sixth_id) {
					$balance2 += $property->sixth_balance;
					$billTemp['sixth_balance'] = $property->sixth_balance;
				}else{
					$balance += $property->sixth_balance;
					$balance2 += $property->sixth_balance;
					$billTemp['sixth_balance'] = $property->sixth_balance;
				}
				if ($notaCredito->id==$organization->seventh_id) {
					$balance -= $property->seventh_balance;
					$balance2 -= $property->seventh_balance;
					$billTemp['seventh_balance'] = $property->seventh_balance;
				}elseif ($charge->id==$organization->seventh_id) {
					$balance2 += $property->seventh_balance;
					$billTemp['seventh_balance'] = $property->seventh_balance;
				}else{
					$balance += $property->seventh_balance;
					$balance2 += $property->seventh_balance;
					$billTemp['seventh_balance'] = $property->seventh_balance;
				}
				if ($notaCredito->id==$organization->eighth_id) {
					$balance -= $property->eighth_balance;
					$balance2 -= $property->eighth_balance;
					$billTemp['eighth_balance'] = $property->eighth_balance;
				}elseif ($charge->id==$organization->eighth_id) {
					$balance2 += $property->eighth_balance;
					$billTemp['eighth_balance'] = $property->eighth_balance;
				}else{
					$balance += $property->eighth_balance;
					$balance2 += $property->eighth_balance;
					$billTemp['eighth_balance'] = $property->eighth_balance;
				}
				if ($notaCredito->id==$organization->nineth_id) {
					$balance -= $property->nineth_balance;
					$balance2 -= $property->nineth_balance;
					$billTemp['nineth_balance'] = $property->nineth_balance;
				}elseif ($charge->id==$organization->nineth_id) {
					$balance2 += $property->nineth_balance;
					$billTemp['nineth_balance'] = $property->nineth_balance;
				}else{
					$balance += $property->nineth_balance;
					$balance2 += $property->nineth_balance;
					$billTemp['nineth_balance'] = $property->nineth_balance;
				}
				if ($notaCredito->id==$organization->tenth_id) {
					$balance -= $property->tenth_balance;
					$balance2 -= $property->tenth_balance;
					$billTemp['tenth_balance'] = $property->tenth_balance;
				}elseif ($charge->id==$organization->tenth_id) {
					$balance2 += $property->tenth_balance;
					$billTemp['tenth_balance'] = $property->tenth_balance;
				}else{
					$balance += $property->tenth_balance;
					$balance2 += $property->tenth_balance;
					$billTemp['tenth_balance'] = $property->tenth_balance;
				}
				$chargeFee = $balance*$organization->charge/100;
				$chargeDoc = new adminph\Document();
				$chargeDoc->concept_id = $charge->id;
				$chargeDoc->property_id = $property->id;
				$chargeDoc->organization_id = $organization->id;
				$chargeDoc->date = date('Y-m-d');
				$chargeDoc->body = "Interés correspondiente al mes ".date('m/Y');
				$chargeDoc->amount = $chargeFee;
				$lastDoc = adminph\Document::where('concept_id',$charge->id)->where('organization_id',$organization->id)->orderBy('number','desc')->first();
				if ($lastDoc != null && $lastDoc != "") {
					$docNumber=$lastDoc->number+1;
				}else{
					$docNumber=1;
				}
				$chargeDoc->number = $docNumber;
				$chargeDoc->save();
				$lastBill = adminph\Bill::where('organization_id',$organization->id)->orderBy('number','desc')->first();
				if ($lastBill != null && $lastBill != "") {
					$billNumber=$lastBill->number+1;
				}else{
					$billNumber=1;
				}
				$mark = null;
				$conceptOne = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->first_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptOneAmount=0;
				foreach ($conceptOne as $key => $doc) {
					$conceptOneAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=1;
					}
				}
				$conceptTwo = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->second_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptTwoAmount=0;
				foreach ($conceptTwo as $key => $doc) {
					$conceptTwoAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=2;
					}
				}
				$conceptTree = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->third_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptTreeAmount=0;
				foreach ($conceptTree as $key => $doc) {
					$conceptTreeAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=3;
					}
				}
				$conceptFour = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->fourth_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptFourAmount=0;
				foreach ($conceptFour as $key => $doc) {
					$conceptFourAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=4;
					}
				}
				$conceptFive = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->fifth_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptFiveAmount=0;
				foreach ($conceptFive as $key => $doc) {
					$conceptFiveAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=5;
					}
				}
				$conceptSix = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->sixth_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptSixAmount=0;
				foreach ($conceptSix as $key => $doc) {
					$conceptSixAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=6;
					}
				}
				$conceptSeven = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->seventh_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptSevenAmount=0;
				foreach ($conceptSeven as $key => $doc) {
					$conceptSevenAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=7;
					}
				}
				$conceptEight = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->eighth_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptEightAmount=0;
				foreach ($conceptEight as $key => $doc) {
					$conceptEightAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=8;
					}
				}
				$conceptNine = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->nineth_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptNineAmount=0;
				foreach ($conceptNine as $key => $doc) {
					$conceptNineAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=9;
					}
				}
				$conceptTen = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->tenth_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptTenAmount=0;
				foreach ($conceptTen as $key => $doc) {
					$conceptTenAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=10;
					}
				}
				if ($organization->discount_state==1) {
					$discount = $admonDoc->amount*$organization->discount/100;
				}else{
					$discount = $organization->discount;
				}
				switch ($mark) {
					case '1':
						$total = $balance2-$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
						break;
					case '2':
						$total = $balance2+$conceptOneAmount-$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
						break;
					case '3':
						$total = $balance2+$conceptOneAmount+$conceptTwoAmount-$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
						break;
					case '4':
						$total = $balance2+$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount-$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
						break;
					case '5':
						$total = $balance2+$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount-$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
						break;
					case '6':
						$total = $balance2+$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount-$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
						break;
					case '7':
						$total = $balance2+$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount-$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
						break;
					case '8':
						$total = $balance2+$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount-$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
						break;
					case '9':
						$total = $balance2+$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount-$conceptNineAmount+$conceptTenAmount;
						break;
					default:
						$total = $balance2+$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount-$conceptTenAmount;
						break;
				}
				$answer = new adminph\Bill();
			   	$answer->number = $billNumber;
			   	$answer->organization_id = $organization->id;
			   	$answer->property_id = $property->id;
			   	$answer->balance = $balance2;
			   	$answer->first_concept = $conceptOneAmount;
			   	$answer->second_concept = $conceptTwoAmount;
			   	$answer->third_concept = $conceptTreeAmount;
			   	$answer->fourth_concept = $conceptFourAmount;
			   	$answer->fifth_concept = $conceptFiveAmount;
			   	$answer->sixth_concept = $conceptSixAmount;
			   	$answer->seventh_concept = $conceptSevenAmount;
			   	$answer->eighth_concept = $conceptEightAmount;
			   	$answer->nineth_concept = $conceptNineAmount;
			   	$answer->tenth_concept = $conceptTenAmount;
			   	$answer->first_balance = $billTemp['first_balance'];
			   	$answer->second_balance = $billTemp['second_balance'];
			   	$answer->third_balance = $billTemp['third_balance'];
			   	$answer->fourth_balance = $billTemp['fourth_balance'];
			   	$answer->fifth_balance = $billTemp['fifth_balance'];
			   	$answer->sixth_balance = $billTemp['sixth_balance'];
			   	$answer->seventh_balance = $billTemp['seventh_balance'];
			   	$answer->eighth_balance = $billTemp['eighth_balance'];
			   	$answer->nineth_balance = $billTemp['nineth_balance'];
			   	$answer->tenth_balance = $billTemp['tenth_balance'];
			   	$answer->discount = $discount;
			   	$answer->total = $total;
			   	$answer->discount_date = date('Y-m-'.$organization->discount_day);
			   if ($answer->save()) {
			   	$mail = ControladorCorreos::ctrEnviarFactura($answer->id);
			   	return redirect('clientes/facturas/'.$answer->id);
			   }
			 } else {
			 	return redirect('clientes/facturas/'.$bill->id);
			 }
		}

	}
	/*======================================
	=            Borrar Factura            =
	======================================*/
	static public function ctrBorrarFactura(){
		if (isset($_POST['idFactura'])) {
		$answer = adminph\Bill::find($_POST['idFactura']);
		$apply = $answer->applied;
		$property=$answer->property;
	   	$month = $answer->created_at->format('m');
	   	$year = $answer->created_at->format('Y');
		if ($apply == '1') {
			$property->first_balance -= $answer->first_concept;
			$property->second_balance -= $answer->second_concept;
			$property->third_balance -= $answer->third_concept;
			$property->fourth_balance -= $answer->fourth_concept;
			$property->fifth_balance -= $answer->fifth_concept;
			$property->sixth_balance -= $answer->sixth_concept;
			$property->seventh_balance -= $answer->seventh_concept;
			$property->eighth_balance -= $answer->eighth_concept;
			$property->nineth_balance -= $answer->nineth_concept;
			$property->tenth_balance -= $answer->tenth_concept;
			$property->save();
		}
		$admon = adminph\Concept::where('name','Cuota ordinaria')->first();
		$extra = adminph\Concept::where('name','Cuota extra')->first();
		$charge = adminph\Concept::where('name','Interes')->first();
		$admonDoc = adminph\Document::where('property_id',$property->id)->where('concept_id',$admon->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->first();
		$admonDoc->delete();
		$extraDoc = adminph\Document::where('property_id',$property->id)->where('concept_id',$extra->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->first();
		$extraDoc->delete();
		$chargeDoc = adminph\Document::where('property_id',$property->id)->where('concept_id',$charge->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->first();
		$chargeDoc->delete();
		$answer->delete();
		}
	}
	static public function ctrFacturaMasiva($id){
			$organization = adminph\Organization::find($id);
			$properties = $organization->propertys;
		   	date_default_timezone_set('America/Bogota');
		   	$month = date('m');
		   	$year = date('Y');
			foreach ($properties as $key => $property) {
				$bill = adminph\Bill::where('property_id',$property->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->first();
				if ($bill==null || $bill=="") {
					$admon = adminph\Concept::where('name','Cuota ordinaria')->first();
					$extra = adminph\Concept::where('name','Cuota extra')->first();
					$charge = adminph\Concept::where('name','Interes')->first();
				   	$notaCredito = adminph\Concept::where('name','Nota credito')->first();
					if ($organization->budget_state==1) {
						$coeff = $property->apartment_coefficient + $property->parking_coefficient + $property->useful_room_coefficient;
						$admonFee = $coeff/100*$organization->budget;
					}else{
						$admonFee = $property->fixed_fee;
					}
					$admonDoc = new adminph\Document();
					$admonDoc->concept_id = $admon->id;
					$admonDoc->property_id = $property->id;
					$admonDoc->organization_id = $organization->id;
					$admonDoc->date = date('Y-m-d');
					$admonDoc->body = "cuota ordinaria correspondiente al mes ".date('m/Y');
					$admonDoc->amount = $admonFee;
					$lastDoc = adminph\Document::where('concept_id',$admon->id)->where('organization_id',$organization->id)->orderBy('number','desc')->first();
					if ($lastDoc != null && $lastDoc != "") {
						$docNumber=$lastDoc->number+1;
					}else{
						$docNumber=1;
					}
					$admonDoc->number = $docNumber;
					$admonDoc->save();
					if ($property->extra_fee_state==1) {
						$coeff = $property->apartment_coefficient + $property->parking_coefficient + $property->useful_room_coefficient;
						$extraFee = $coeff/100*$organization->extra_fee;
					}else{
						$extraFee = 0;
					}
					$extraDoc = new adminph\Document();
					$extraDoc->concept_id = $extra->id;
					$extraDoc->property_id = $property->id;
					$extraDoc->organization_id = $organization->id;
					$extraDoc->date = date('Y-m-d');
					$extraDoc->body = "cuota extra correspondiente al mes ".date('m/Y');
					$extraDoc->amount = $extraFee;
					$lastDoc = adminph\Document::where('concept_id',$extra->id)->where('organization_id',$organization->id)->orderBy('number','desc')->first();
					if ($lastDoc != null && $lastDoc != "") {
						$docNumber=$lastDoc->number+1;
					}else{
						$docNumber=1;
					}
					$extraDoc->number = $docNumber;
					$extraDoc->save();
					$balance = 0;
					$balance2 = 0;
					$billTemp = array();
					if ($notaCredito->id==$organization->first_id) {
						$balance -= $property->first_balance;
						$balance2 -= $property->first_balance;
						$billTemp['first_balance'] = $property->first_balance;
					}elseif ($charge->id==$organization->first_id) {
						$balance2 += $property->first_balance;
						$billTemp['first_balance'] = $property->first_balance;
					}else{
						$balance2 += $property->first_balance;
						$balance += $property->first_balance;
						$billTemp['first_balance'] = $property->first_balance;
					}
					if ($notaCredito->id==$organization->second_id) {
						$balance -= $property->second_balance;
						$balance2 -= $property->second_balance;
						$billTemp['second_balance'] = $property->second_balance;
					}elseif ($charge->id==$organization->second_id) {
						$balance2 += $property->second_balance;
						$billTemp['second_balance'] = $property->second_balance;
					}else{
						$balance += $property->second_balance;
						$balance2 += $property->second_balance;
						$billTemp['second_balance'] = $property->second_balance;
					}
					if ($notaCredito->id==$organization->third_id) {
						$balance -= $property->third_balance;
						$balance2 -= $property->third_balance;
						$billTemp['third_balance'] = $property->third_balance;
					}elseif ($charge->id==$organization->third_id) {
						$balance2 += $property->third_balance;
						$billTemp['third_balance'] = $property->third_balance;
					}else{
						$balance2 += $property->third_balance;
						$balance += $property->third_balance;
						$billTemp['third_balance'] = $property->third_balance;
					}
					if ($notaCredito->id==$organization->fourth_id) {
						$balance -= $property->fourth_balance;
						$balance2 -= $property->fourth_balance;
						$billTemp['fourth_balance'] = $property->fourth_balance;
					}elseif ($charge->id==$organization->fourth_id) {
						$balance2 += $property->fourth_balance;
						$billTemp['fourth_balance'] = $property->fourth_balance;
					}else{
						$balance += $property->fourth_balance;
						$balance2 += $property->fourth_balance;
						$billTemp['fourth_balance'] = $property->fourth_balance;
					}
					if ($notaCredito->id==$organization->fifth_id) {
						$balance -= $property->fifth_balance;
						$balance2 -= $property->fifth_balance;
						$billTemp['fifth_balance'] = $property->fifth_balance;
					}elseif ($charge->id==$organization->fifth_id) {
						$balance2 += $property->fifth_balance;
						$billTemp['fifth_balance'] = $property->fifth_balance;
					}else{
						$balance += $property->fifth_balance;
						$balance2 += $property->fifth_balance;
						$billTemp['fifth_balance'] = $property->fifth_balance;
					}
					if ($notaCredito->id==$organization->sixth_id) {
						$balance -= $property->sixth_balance;
						$balance2 -= $property->sixth_balance;
						$billTemp['sixth_balance'] = $property->sixth_balance;
					}elseif ($charge->id==$organization->sixth_id) {
						$balance2 += $property->sixth_balance;
						$billTemp['sixth_balance'] = $property->sixth_balance;
					}else{
						$balance += $property->sixth_balance;
						$balance2 += $property->sixth_balance;
						$billTemp['sixth_balance'] = $property->sixth_balance;
					}
					if ($notaCredito->id==$organization->seventh_id) {
						$balance -= $property->seventh_balance;
						$balance2 -= $property->seventh_balance;
						$billTemp['seventh_balance'] = $property->seventh_balance;
					}elseif ($charge->id==$organization->seventh_id) {
						$balance2 += $property->seventh_balance;
						$billTemp['seventh_balance'] = $property->seventh_balance;
					}else{
						$balance += $property->seventh_balance;
						$balance2 += $property->seventh_balance;
						$billTemp['seventh_balance'] = $property->seventh_balance;
					}
					if ($notaCredito->id==$organization->eighth_id) {
						$balance -= $property->eighth_balance;
						$balance2 -= $property->eighth_balance;
						$billTemp['eighth_balance'] = $property->eighth_balance;
					}elseif ($charge->id==$organization->eighth_id) {
						$balance2 += $property->eighth_balance;
						$billTemp['eighth_balance'] = $property->eighth_balance;
					}else{
						$balance += $property->eighth_balance;
						$balance2 += $property->eighth_balance;
						$billTemp['eighth_balance'] = $property->eighth_balance;
					}
					if ($notaCredito->id==$organization->nineth_id) {
						$balance -= $property->nineth_balance;
						$balance2 -= $property->nineth_balance;
						$billTemp['nineth_balance'] = $property->nineth_balance;
					}elseif ($charge->id==$organization->nineth_id) {
						$balance2 += $property->nineth_balance;
						$billTemp['nineth_balance'] = $property->nineth_balance;
					}else{
						$balance += $property->nineth_balance;
						$balance2 += $property->nineth_balance;
						$billTemp['nineth_balance'] = $property->nineth_balance;
					}
					if ($notaCredito->id==$organization->tenth_id) {
						$balance -= $property->tenth_balance;
						$balance2 -= $property->tenth_balance;
						$billTemp['tenth_balance'] = $property->tenth_balance;
					}elseif ($charge->id==$organization->tenth_id) {
						$balance2 += $property->tenth_balance;
						$billTemp['tenth_balance'] = $property->tenth_balance;
					}else{
						$balance += $property->tenth_balance;
						$balance2 += $property->tenth_balance;
						$billTemp['tenth_balance'] = $property->tenth_balance;
					}
					$chargeFee = $balance*$organization->charge/100;
					$chargeDoc = new adminph\Document();
					$chargeDoc->concept_id = $charge->id;
					$chargeDoc->property_id = $property->id;
					$chargeDoc->organization_id = $organization->id;
					$chargeDoc->date = date('Y-m-d');
					$chargeDoc->body = "Interés correspondiente al mes ".date('m/Y');
					$chargeDoc->amount = $chargeFee;
					$lastDoc = adminph\Document::where('concept_id',$charge->id)->where('organization_id',$organization->id)->orderBy('number','desc')->first();
					if ($lastDoc != null && $lastDoc != "") {
						$docNumber=$lastDoc->number+1;
					}else{
						$docNumber=1;
					}
					$chargeDoc->number = $docNumber;
					$chargeDoc->save();
					$lastBill = adminph\Bill::where('organization_id',$organization->id)->orderBy('number','desc')->first();
					if ($lastBill != null && $lastBill != "") {
						$billNumber=$lastBill->number+1;
					}else{
						$billNumber=1;
					}
					$mark = null;
				$conceptOne = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->first_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptOneAmount=0;
				foreach ($conceptOne as $key => $doc) {
					$conceptOneAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=1;
					}
				}
				$conceptTwo = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->second_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptTwoAmount=0;
				foreach ($conceptTwo as $key => $doc) {
					$conceptTwoAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=2;
					}
				}
				$conceptTree = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->third_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptTreeAmount=0;
				foreach ($conceptTree as $key => $doc) {
					$conceptTreeAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=3;
					}
				}
				$conceptFour = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->fourth_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptFourAmount=0;
				foreach ($conceptFour as $key => $doc) {
					$conceptFourAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=4;
					}
				}
				$conceptFive = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->fifth_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptFiveAmount=0;
				foreach ($conceptFive as $key => $doc) {
					$conceptFiveAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=5;
					}
				}
				$conceptSix = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->sixth_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptSixAmount=0;
				foreach ($conceptSix as $key => $doc) {
					$conceptSixAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=6;
					}
				}
				$conceptSeven = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->seventh_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptSevenAmount=0;
				foreach ($conceptSeven as $key => $doc) {
					$conceptSevenAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=7;
					}
				}
				$conceptEight = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->eighth_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptEightAmount=0;
				foreach ($conceptEight as $key => $doc) {
					$conceptEightAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=8;
					}
				}
				$conceptNine = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->nineth_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptNineAmount=0;
				foreach ($conceptNine as $key => $doc) {
					$conceptNineAmount += $doc->amount;
					if ($mark == null && $doc->concept_id==$notaCredito->id) {
						$mark=9;
					}
				}
				$conceptTen = adminph\Document::where('property_id',$property->id)->where('concept_id',$organization->tenth_id)->whereMonth('date',$month)->whereYear('date',$year)->get();
				$conceptTenAmount=0;
					foreach ($conceptTen as $key => $doc) {
						$conceptTenAmount += $doc->amount;
						if ($mark == null && $doc->concept_id==$notaCredito->id) {
							$mark=10;
						}
					}
					if ($organization->discount_state==1) {
						$discount = $admonDoc->amount*$organization->discount/100;
					}else{
						$discount = $organization->discount;
					}
					switch ($mark) {
						case '1':
							$total = $balance2-$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
							break;
						case '2':
							$total = $balance2+$conceptOneAmount-$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
							break;
						case '3':
							$total = $balance2+$conceptOneAmount+$conceptTwoAmount-$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
							break;
						case '4':
							$total = $balance2+$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount-$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
							break;
						case '5':
							$total = $balance2+$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount-$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
							break;
						case '6':
							$total = $balance2+$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount-$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
							break;
						case '7':
							$total = $balance2+$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount-$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
							break;
						case '8':
							$total = $balance2+$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount-$conceptEightAmount+$conceptNineAmount+$conceptTenAmount;
							break;
						case '9':
							$total = $balance2+$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount-$conceptNineAmount+$conceptTenAmount;
							break;
						default:
							$total = $balance2+$conceptOneAmount+$conceptTwoAmount+$conceptTreeAmount+$conceptFourAmount+$conceptFiveAmount+$conceptSixAmount+$conceptSevenAmount+$conceptEightAmount+$conceptNineAmount-$conceptTenAmount;
							break;
					}
					$answer = new adminph\Bill();
				   	$answer->number = $billNumber;
				   	$answer->organization_id = $organization->id;
				   	$answer->property_id = $property->id;
				   	$answer->balance = $balance2;
				   	$answer->first_concept = $conceptOneAmount;
				   	$answer->second_concept = $conceptTwoAmount;
				   	$answer->third_concept = $conceptTreeAmount;
				   	$answer->fourth_concept = $conceptFourAmount;
				   	$answer->fifth_concept = $conceptFiveAmount;
				   	$answer->sixth_concept = $conceptSixAmount;
				   	$answer->seventh_concept = $conceptSevenAmount;
				   	$answer->eighth_concept = $conceptEightAmount;
				   	$answer->nineth_concept = $conceptNineAmount;
				   	$answer->tenth_concept = $conceptTenAmount;
				   	$answer->first_balance = $billTemp['first_balance'];
				   	$answer->second_balance = $billTemp['second_balance'];
				   	$answer->third_balance = $billTemp['third_balance'];
				   	$answer->fourth_balance = $billTemp['fourth_balance'];
				   	$answer->fifth_balance = $billTemp['fifth_balance'];
				   	$answer->sixth_balance = $billTemp['sixth_balance'];
				   	$answer->seventh_balance = $billTemp['seventh_balance'];
				   	$answer->eighth_balance = $billTemp['eighth_balance'];
				   	$answer->nineth_balance = $billTemp['nineth_balance'];
				   	$answer->tenth_balance = $billTemp['tenth_balance'];
				   	$answer->discount = $discount;
				   	$answer->total = $total;
				   	$answer->discount_date = date('Y-m-'.$organization->discount_day);
				   if ($answer->save()) {
				   	$mail = ControladorCorreos::ctrEnviarFactura($answer->id);
				   }
			 }
		}
		return redirect('pdf/facturas/masa/'.$organization->id);
	}
	static public function ctrFacturasViejas($id){ 
		$handle = fopen($_FILES['facturas']['tmp_name'], "r");
		while ($csvLine = fgetcsv($handle, 1000, ";")) {
			$csvLine = array_map("utf8_encode", $csvLine); //added
			$billNumber = $csvLine[0];
		   	$organization = adminph\Organization::where('code',$csvLine[1])->first();
		   	$property = adminph\Property::where('organization_id',$organization->id)->where('apartment',$csvLine[2])->first();
			$admon = adminph\Concept::where('name','Cuota ordinaria')->first();
			$extra = adminph\Concept::where('name','Cuota extra')->first();
			$charge = adminph\Concept::where('name','Interes')->first();
			if ($organization->first_id==$admon->id) {
				$admonAmount=$csvLine[3];
			}elseif($organization->first_id==$extra->id){
				$extraAmount=$csvLine[3];
			}elseif($organization->first_id==$charge->id){
				$chargeAmount=$csvLine[3];
			}
			if ($organization->second_id==$admon->id) {
				$admonAmount=$csvLine[4];
			}elseif($organization->second_id==$extra->id){
				$extraAmount=$csvLine[4];
			}elseif($organization->second_id==$charge->id){
				$chargeAmount=$csvLine[4];
			}
			if ($organization->third_id==$admon->id) {
				$admonAmount=$csvLine[5];
			}elseif($organization->third_id==$extra->id){
				$extraAmount=$csvLine[5];
			}elseif($organization->third_id==$charge->id){
				$chargeAmount=$csvLine[5];
			}
			if ($organization->fourth_id==$admon->id) {
				$admonAmount=$csvLine[7];
			}elseif($organization->fourth_id==$extra->id){
				$extraAmount=$csvLine[7];
			}elseif($organization->fourth_id==$charge->id){
				$chargeAmount=$csvLine[7];
			}
			if ($organization->fifth_id==$admon->id) {
				$admonAmount=$csvLine[8];
			}elseif($organization->fifth_id==$extra->id){
				$extraAmount=$csvLine[8];
			}elseif($organization->fifth_id==$charge->id){
				$chargeAmount=$csvLine[8];
			}
			if ($organization->sixth_id==$admon->id) {
				$admonAmount=$csvLine[9];
			}elseif($organization->sixth_id==$extra->id){
				$extraAmount=$csvLine[9];
			}elseif($organization->sixth_id==$charge->id){
				$chargeAmount=$csvLine[9];
			}
			if ($organization->seventh_id==$admon->id) {
				$admonAmount=$csvLine[10];
			}elseif($organization->seventh_id==$extra->id){
				$extraAmount=$csvLine[10];
			}elseif($organization->seventh_id==$charge->id){
				$chargeAmount=$csvLine[10];
			}
			if ($organization->eighth_id==$admon->id) {
				$admonAmount=$csvLine[11];
			}elseif($organization->eighth_id==$extra->id){
				$extraAmount=$csvLine[11];
			}elseif($organization->eighth_id==$charge->id){
				$chargeAmount=$csvLine[11];
			}
			if ($organization->nineth_id==$admon->id) {
				$admonAmount=$csvLine[12];
			}elseif($organization->nineth_id==$extra->id){
				$extraAmount=$csvLine[12];
			}elseif($organization->nineth_id==$charge->id){
				$chargeAmount=$csvLine[12];
			}
			if ($organization->tenth_id==$admon->id) {
				$admonAmount=$csvLine[13];
			}elseif($organization->tenth_id==$extra->id){
				$extraAmount=$csvLine[13];
			}elseif($organization->tenth_id==$charge->id){
				$chargeAmount=$csvLine[13];
			}
			$admonDoc = new adminph\Document();
			$admonDoc->concept_id = $admon->id;
			$admonDoc->property_id = $property->id;
			$admonDoc->organization_id = $organization->id;
			$admonDoc->date = date(substr($csvLine[27],0,10));
			$admonDoc->body = "cuota ordinaria correspondiente al mes ".date(substr($csvLine[27],5,2).'/'.substr($csvLine[27],0,4));
			$admonDoc->amount = $admonAmount;
			$docNumber=1;
			$admonDoc->number = $docNumber;
			$admonDoc->created_at=$csvLine[27];
			$admonDoc->save();
			$extraDoc = new adminph\Document();
			$extraDoc->concept_id = $extra->id;
			$extraDoc->property_id = $property->id;
			$extraDoc->organization_id = $organization->id;
			$extraDoc->date = date(substr($csvLine[27],0,10));
			$extraDoc->body = "cuota extra correspondiente al mes ".date(substr($csvLine[27],5,2).'/'.substr($csvLine[27],0,4));
			$extraDoc->amount = $extraAmount;
			$extraDoc->number = $docNumber;
			$extraDoc->created_at=$csvLine[27];
			$extraDoc->save();
			$chargeDoc = new adminph\Document();
			$chargeDoc->concept_id = $charge->id;
			$chargeDoc->property_id = $property->id;
			$chargeDoc->organization_id = $organization->id;
			$chargeDoc->date = date(substr($csvLine[27],0,10));
			$chargeDoc->body = "Interés correspondiente al mes ".date(substr($csvLine[27],5,2).'/'.substr($csvLine[27],0,4));
			$chargeDoc->amount = $chargeAmount;
			$chargeDoc->number = $docNumber;
			$chargeDoc->created_at=$csvLine[27];
			$chargeDoc->save();
			$answer = new adminph\Bill();
		   	$answer->number = $billNumber;
		   	$answer->organization_id = $organization->id;
		   	$answer->property_id = $property->id;
		   	$answer->balance = $csvLine[28];
		   	$answer->first_concept = $csvLine[3];
		   	$answer->second_concept = $csvLine[4];
		   	$answer->third_concept = $csvLine[5];
		   	$answer->fourth_concept = $csvLine[7];
		   	$answer->fifth_concept = $csvLine[8];
		   	$answer->sixth_concept = $csvLine[9];
		   	$answer->seventh_concept = $csvLine[10];
		   	$answer->eighth_concept = $csvLine[11];
		   	$answer->nineth_concept = $csvLine[12];
		   	$answer->tenth_concept = $csvLine[13];
		   	$answer->first_balance = $csvLine[14];
		   	$answer->second_balance = $csvLine[15];
		   	$answer->third_balance = $csvLine[16];
		   	$answer->fourth_balance = $csvLine[17];
		   	$answer->fifth_balance = $csvLine[18];
		   	$answer->sixth_balance = $csvLine[19];
		   	$answer->seventh_balance = $csvLine[20];
		   	$answer->eighth_balance = $csvLine[21];
		   	$answer->nineth_balance = $csvLine[22];
		   	$answer->tenth_balance = $csvLine[23];
		   	$answer->discount = $csvLine[6];
		   	$answer->applied = 1;
		   	$answer->total = $csvLine[25];
		   	$answer->discount_date = $csvLine[26];
		   	$answer->created_at = $csvLine[27];
		   	$answer->save();
		}
		return redirect('facturas');
	}
	static public function ctrAplicarFacturas(Request $request){
    	if ($request->session()->get('rank')=='Admin') {
			$bills = adminph\Bill::where('applied',0)->get();
			$conceptos = adminph\Concept::all();
			$notaCredito = adminph\Concept::where('name','Nota credito')->first();
			$bolsas=array();
			foreach ($bills as $key => $bill) {
				$property=$bill->property;
				$property->first_balance += $bill->first_concept;
				$property->second_balance += $bill->second_concept;
				$property->third_balance += $bill->third_concept;
				$property->fourth_balance += $bill->fourth_concept;
				$property->fifth_balance += $bill->fifth_concept;
				$property->sixth_balance += $bill->sixth_concept;
				$property->seventh_balance += $bill->seventh_concept;
				$property->eighth_balance += $bill->eighth_concept;
				$property->nineth_balance += $bill->nineth_concept;
				$property->tenth_balance += $bill->tenth_concept;
				$property->save();
				$bill->applied = 1;
				$bill->save();
				$unidad = $property->organization;
				foreach ($conceptos as $concepto) {
				 	if ($concepto->id == $unidad->first_id) {
				 		$bolsas[$concepto->id]=$bill->first_concept;
				 	}elseif ($concepto->id == $unidad->second_id) {
				 		$bolsas[$concepto->id]=$bill->second_concept;
				 	}elseif ($concepto->id == $unidad->third_id) {
				 		$bolsas[$concepto->id]=$bill->third_concept;
				 	}elseif ($concepto->id == $unidad->fourth_id) {
				 		$bolsas[$concepto->id]=$bill->fourth_concept;
				 	}elseif ($concepto->id == $unidad->fifth_id) {
				 		$bolsas[$concepto->id]=$bill->fifth_concept;
				 	}elseif ($concepto->id == $unidad->sixth_id) {
				 		$bolsas[$concepto->id]=$bill->sixth_concept;
				 	}elseif ($concepto->id == $unidad->seventh_id) {
				 		$bolsas[$concepto->id]=$bill->seventh_concept;
				 	}elseif ($concepto->id == $unidad->eighth_id) {
				 		$bolsas[$concepto->id]=$bill->eighth_concept;
				 	}elseif ($concepto->id == $unidad->nineth_id) {
				 		$bolsas[$concepto->id]=$bill->nineth_concept;
				 	}elseif ($concepto->id == $unidad->tenth_id) {
				 		$bolsas[$concepto->id]=$bill->tenth_concept;
				 	}
				 }
				 foreach ($bolsas as $id => $bolsa) {
					if ($id != $notaCredito->id) {	
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$id;
						$note->amount=$bolsa;
						$note->save();
					}
				  } 

			}
    		return redirect('facturas');
    	}else{
    		return redirect('/');
    	}
	}
	public function ajaxLimpiarFacturas(){
		$month = date("m");
		$year = date("Y");
		if (session('rank')=="Admin" && isset($_POST['idUnidad'])) {
		$bills = adminph\Bill::where('organization_id',$_POST['idUnidad'])->whereMonth('created_at',$month)->whereYear('created_at',$year)->get();
		foreach ($bills as $key => $answer) {
			$apply = $answer->applied;
			$property=$answer->property;
		   	$month = $answer->created_at->format('m');
		   	$year = $answer->created_at->format('Y');
			if ($apply == '1') {
				$property->first_balance -= $answer->first_concept;
				$property->second_balance -= $answer->second_concept;
				$property->third_balance -= $answer->third_concept;
				$property->fourth_balance -= $answer->fourth_concept;
				$property->fifth_balance -= $answer->fifth_concept;
				$property->sixth_balance -= $answer->sixth_concept;
				$property->seventh_balance -= $answer->seventh_concept;
				$property->eighth_balance -= $answer->eighth_concept;
				$property->nineth_balance -= $answer->nineth_concept;
				$property->tenth_balance -= $answer->tenth_concept;
				$property->save();
			}
			$admon = adminph\Concept::where('name','Cuota ordinaria')->first();
			$extra = adminph\Concept::where('name','Cuota extra')->first();
			$charge = adminph\Concept::where('name','Interes')->first();
			$admonDoc = adminph\Document::where('property_id',$property->id)->where('concept_id',$admon->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->first();
			$admonDoc->delete();
			$extraDoc = adminph\Document::where('property_id',$property->id)->where('concept_id',$extra->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->first();
			$extraDoc->delete();
			$chargeDoc = adminph\Document::where('property_id',$property->id)->where('concept_id',$charge->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->first();
			$chargeDoc->delete();
			$answer->delete();
			}
		}
	}
	public function ajaxConsultarFactura(){
		$answer = adminph\Bill::find($_POST['idFactura']);
		echo json_encode($answer);
	} 
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatableFacturas()
	{	
	if (session('rank')=='Admin') {
  		$productos = adminph\Bill::all();
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
	  $productos = adminph\Bill::where('property_id',$answer->property_id)->get();
	}

  	echo '{
			"data": [';

			for($i = 0; $i < count($productos)-1; $i++){
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><a href='clientes/facturas/".$productos[$i]->id."' target='_blank'><button class='btn btn-primary'><i class='far fa-eye'></i></button></a><button class='btn btn-danger btnBorrarFactura' idFactura='".$productos[$i]->id."'><i class='fa fa-times'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'><a href='clientes/facturas/".$productos[$i]->id."' target='_blank'><button class='btn btn-primary'><i class='far fa-eye'></i></button></a></div>";
                }
				 echo '[
			      "'.($i+1).'",
			      "'.$productos[$i]->number.'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->property->apartment.'",
			      "'.$productos[$i]->total.'",
			      "'.$productos[$i]->discount_date.'",
			      "'.$buttons.'"
			    ],';

			}
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><a href='clientes/facturas/".$productos[count($productos)-1]->id."' target='_blank'><button class='btn btn-primary'><i class='far fa-eye'></i></button></a><button class='btn btn-danger btnBorrarFactura' idFactura='".$productos[count($productos)-1]->id."'><i class='fa fa-times'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'><a href='clientes/facturas/".$productos[count($productos)-1]->id."' target='_blank'><button class='btn btn-primary'><i class='far fa-eye'></i></button></a></div>";
                }
				 echo '[
			      "'.(count($productos)).'",
			      "'.$productos[count($productos)-1]->number.'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->property->apartment.'",
			      "'.$productos[count($productos)-1]->total.'",
			      "'.$productos[count($productos)-1]->discount_date.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
}
