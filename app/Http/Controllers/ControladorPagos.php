<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use adminph;

class ControladorPagos extends Controller
{
    /*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearPago(){

		if (isset($_POST['newPayment'])) {
			if (preg_match('/^[0-9.]+$/', $_POST["newAmount"])) {
				$lastPayment = adminph\Payment::where('organization_id',$_POST['newOrganizationId'])->orderBy('created_at','desc')->first();
			   	$answer = new adminph\Payment();
				if (is_object($lastPayment)) {
					$answer->number = $lastPayment->number + 1;	
				}else{
					$answer->number = 1;
				}
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->property_id = $_POST['newPropertyId'];
			   	$answer->payment_date = $_POST['newPaymentDate'];
			   	$property = $answer->property;
			   	$organization = $property->organization;
			   	$answer->organization_code = $organization->code;
			   	$answer->property_number = $property->apartment;
			   	$answer->amount = $_POST['newAmount'];
			   	$answer->applied = 1;
			   	$answer->ref_document = $_POST['newRefDocument'];
			   if ($answer->save()) {
			   	date_default_timezone_set('America/Bogota');
			   	$month = date('m');
			   	$bill = adminph\Bill::where('property_id',$answer->property_id)->whereMonth('created_at',$month)->orderBy('id','desc')->first();
			   	if ($bill->applied == 1) {
			   		$bill->first_concept = 0;
			   		$bill->second_concept = 0;
			   		$bill->third_concept = 0;
			   		$bill->fourth_concept = 0;
			   		$bill->fifth_concept = 0;
			   		$bill->sixth_concept = 0;
			   		$bill->seventh_concept = 0;
			   		$bill->eighth_concept = 0;
			   		$bill->nineth_concept = 0;
			   		$bill->tenth_concept = 0;
			   	}
			   	$admon = adminph\Concept::where('name','Cuota ordinaria')->first();
			   	$notaCredito = adminph\Concept::where('name','Nota credito')->first();
			   	$close = 'Y-m-'.$organization->discount_day;
				$factor= -1;
			   	if ($notaCredito->id == $organization->first_id) {
			   			$bill->first_concept *= $factor;
			   			$property->first_balance *= $factor;
			   	}elseif ($notaCredito->id == $organization->second_id) {
			   			$property->second_balance *= $factor;
			   			$bill->second_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->third_id) {
			   			$property->third_balance *= $factor;
			   			$bill->third_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->fourth_id) {
			   			$property->fourth_balance *= $factor;
			   			$bill->fourth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->fifth_id) {
			   			$property->fifth_balance *= $factor;
			   			$bill->fifth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->sixth_id) {
			   			$property->sixth_balance *= $factor;
			   			$bill->sixth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->seventh_id) {
			   			$property->seventh_balance *= $factor;
			   			$bill->seventh_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->eighth_id) {
			   			$property->eighth_balance *= $factor;
			   			$bill->eighth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->nineth_id) {
			   			$property->nineth_balance *= $factor;
			   			$bill->nineth_concept *= $factor;
			   	}else {
			   			$property->tenth_balance *= $factor;
			   			$bill->tenth_concept *= $factor;
			   	}
				$credit = $answer->amount;
			   	if (strtotime($answer->payment_date)<=strtotime(date($close))) {
			   		if ($bill->applied != 1) {
			   			$credit += $bill->discount;
						$log= new adminph\Backlog();
						$log->property_id=$property->id;
						$log->payment_id=$answer->id;
						$log->concept_id=$admon->id;
						$log->amount=(-1)*$bill->discount;
						$log->payment_date=$answer->payment_date;
						$log->save();
			   			$discount = adminph\Concept::where('name','Descuento')->first();
						$discountDoc = new adminph\Document();
						$discountDoc->concept_id = $discount->id;
						$discountDoc->property_id = $property->id;
						$discountDoc->organization_id = $organization->id;
						$discountDoc->date=$answer->payment_date;
						$discountDoc->body = "Descuento correspondiente al mes ".date('m/Y');
						$discountDoc->amount = $bill->discount;
						$lastDoc = adminph\Document::where('concept_id',$discount->id)->where('organization_id',$organization->id)->orderBy('number','desc')->first();
						if ($lastDoc != null && $lastDoc != "") {
							$docNumber=$lastDoc->number+1;
						}else{
							$docNumber=1;
						}
						$discountDoc->number = $docNumber;
						$discountDoc->save();
			   		}
				}
				$total = $bill->first_concept + $property->first_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->first_id;
				   	if ($notaCredito->id == $organization->first_id) {
				   		$log->amount = $property->first_balance;
				   	}else{
						$log->amount=$total;
					}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->first_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->first_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->first_id;
				   	if ($notaCredito->id == $organization->first_id) {
				   		$log->amount = $property->first_balance;
				   	}else{
						$log->amount=$credit;
						$credit2=$credit;
						$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->first_id)->orderBy('created_at','asc')->get();
						if (!$oldNotes->isEmpty()) {
							foreach ($oldNotes as $oldNote) {
								if ($credit2 >= $oldNote->amount) {
									$credit2 -= $oldNote->amount;
									$oldNote->delete();
								}elseif ($credit2 > 0) {
									$oldNote->amount -= $credit2;
									$oldNote->save();
									$credit2 = 0;
								}
							}
						}
						if ($credit2 > 0) {
							$amount = $bill->first_concept-$credit2;
							$note = new adminph\Note();
							$note->property_id=$property->id;
							$note->bill_id=$bill->id;
							$note->concept_id=$organization->first_id;
							$note->amount=$amount;
							$note->save();
							$credit2 = 0;
						}
					}	
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->first_balance=$total;
				}else{
					$property->first_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->first_id;
					$note->amount=$bill->first_balance;
					$note->save();
				}
				$total = $bill->second_concept + $property->second_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->second_id;
				   	if ($notaCredito->id == $organization->second_id) {
				   		$log->amount = $property->second_balance;
				   	}else{
						$log->amount=$total;
					}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->second_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->second_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->second_id;
				   	if ($notaCredito->id == $organization->second_id) {
				   		$log->amount = $property->second_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->second_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->second_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->second_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}

				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->second_balance=$total;
				}else{
					$property->second_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->second_id;
					$note->amount=$bill->second_balance;
					$note->save();
				}
				$total = $bill->third_concept + $property->third_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->third_id;
				   	if ($notaCredito->id == $organization->third_id) {
				   		$log->amount = $property->third_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->third_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->third_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->third_id;
				   	if ($notaCredito->id == $organization->third_id) {
				   		$log->amount = $property->third_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->third_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->third_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->third_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->third_balance=$total;
				}else{
					$property->third_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->third_id;
					$note->amount=$bill->third_balance;
					$note->save();
				}
				$total = $bill->fourth_concept + $property->fourth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fourth_id;
				   	if ($notaCredito->id == $organization->fourth_id) {
				   		$log->amount = $property->fourth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->fourth_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->fourth_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fourth_id;
				   	if ($notaCredito->id == $organization->fourth_id) {
				   		$log->amount = $property->fourth_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->fourth_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->fourth_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->fourth_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->fourth_balance=$total;
				}else{
					$property->fourth_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->fourth_id;
					$note->amount=$bill->fourth_balance;
					$note->save();
				}
				$total = $bill->fifth_concept + $property->fifth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fifth_id;
				   	if ($notaCredito->id == $organization->fifth_id) {
				   		$log->amount = $property->fifth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->fifth_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->fifth_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fifth_id;
					$log->concept_id=$organization->fifth_id;
				   	if ($notaCredito->id == $organization->fifth_id) {
				   		$log->amount = $property->fifth_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->fifth_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->fifth_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->fifth_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->fifth_balance=$total;
				}else{
					$property->fifth_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->fifth_id;
					$note->amount=$bill->fifth_balance;
					$note->save();
				}
				$total = $bill->sixth_concept + $property->sixth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->sixth_id;
					$log->concept_id=$organization->sixth_id;
				   	if ($notaCredito->id == $organization->sixth_id) {
				   		$log->amount = $property->sixth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->sixth_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->sixth_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->sixth_id;
				   	if ($notaCredito->id == $organization->sixth_id) {
				   		$log->amount = $property->sixth_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->sixth_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->sixth_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->sixth_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}

				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->sixth_balance=$total;
				}else{
					$property->sixth_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->sixth_id;
					$note->amount=$bill->sixth_balance;
					$note->save();
				}
				$total = $bill->seventh_concept + $property->seventh_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->seventh_id;
				   	if ($notaCredito->id == $organization->seventh_id) {
				   		$log->amount = $property->seventh_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->seventh_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->seventh_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->seventh_id;
				   	if ($notaCredito->id == $organization->seventh_id) {
				   		$log->amount = $property->seventh_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->seventh_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->seventh_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->seventh_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->seventh_balance=$total;
				}else{
					$property->seventh_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->seventh_id;
					$note->amount=$bill->seventh_balance;
					$note->save();
				}
				$total = $bill->eighth_concept + $property->eighth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->eighth_id;
				   	if ($notaCredito->id == $organization->eighth_id) {
				   		$log->amount = $property->eighth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->eighth_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->eighth_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->eighth_id;
				   	if ($notaCredito->id == $organization->eighth_id) {
				   		$log->amount = $property->eighth_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->eighth_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->eighth_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->eighth_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->eighth_balance=$total;
				}else{
					$property->eighth_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->eighth_id;
					$note->amount=$bill->eighth_balance;
					$note->save();
				}
				$total = $bill->nineth_concept + $property->nineth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->nineth_id;
				   	if ($notaCredito->id == $organization->nineth_id) {
				   		$log->amount = $property->nineth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->nineth_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->nineth_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->nineth_id;
				   	if ($notaCredito->id == $organization->nineth_id) {
				   		$log->amount = $property->nineth_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->nineth_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->nineth_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->nineth_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->nineth_balance=$total;
				}else{
					$property->nineth_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->nineth_id;
					$note->amount=$bill->nineth_balance;
					$note->save();
				}
				$total = $bill->tenth_concept + $property->tenth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->tenth_id;
				   	if ($notaCredito->id == $organization->tenth_id) {
				   		$log->amount = $property->tenth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->tenth_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->tenth_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->tenth_id;
				   	if ($notaCredito->id == $organization->tenth_id) {
				   		$log->amount = $property->tenth_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->tenth_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->tenth_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->tenth_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->tenth_balance=$total;
				}else{
					$property->tenth_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->tenth_id;
					$note->amount=$bill->tenth_balance;
					$note->save();
				}
				if ($credit>0) {
					if ($organization->first_id==$notaCredito->id) {
						$property->first_balance += $credit;
					}else{
						$property->first_balance -= $credit;
					}
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->first_id;
					$log->amount=$credit;
					$log->payment_date=$answer->payment_date;
					$log->save();
				}
				$property->save();
			   	if ($bill->applied != 1) {
					$bill->applied = 1;
					$bill->save();
				}
			   	return redirect('pagos');
			   }
			 } else {
			 	return view('layouts.payments_error');
			 }
		}

	}
	/*===================================
	=            USER EDIT            =
	===================================*/
	
	static public function ctrEditarPago(){

		if (isset($_POST['editPayment'])) {
			if (preg_match('/^[0-9.]+$/', $_POST["newAmount"])){
				$answer = adminph\Payment::find($_POST['editId']);
				$backlogs = $answer->backlogs;
				$property = $answer->property;
				$organization = $property->organization;
			   	$month = $answer->payment_date->format('m');
			   	$year = $answer->payment_date->format('Y');
				$discount = adminph\Concept::where('name','Descuento')->first();
				$discountDoc = adminph\Document::where('property_id',$property->id)->where('concept_id',$discount->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->first();
				$discountDoc->delete();
				foreach ($backlogs as $key => $backlog) {
					$concept = $backlog->concept;
					if ($concept->name=='Nota crédito') {
						$backlog->amount *= -1;
					}
				   	if ($backlog->concept_id == $organization->first_id) {
				   			$property->first_balance += $backlog->amount;
				   	}elseif ($backlog->concept_id == $organization->second_id) {
				   			$property->second_balance += $backlog->amount;
				   	}elseif ($backlog->concept_id == $organization->third_id) {
				   			$property->third_balance += $backlog->amount;
				   	}elseif ($backlog->concept_id == $organization->fourth_id) {
				   			$property->fourth_balance += $backlog->amount;
				   	}elseif ($backlog->concept_id == $organization->fifth_id) {
				   			$property->fifth_balance += $backlog->amount;
				   	}elseif ($backlog->concept_id == $organization->sixth_id) {
				   			$property->sixth_balance += $backlog->amount;
				   	}elseif ($backlog->concept_id == $organization->seventh_id) {
				   			$property->seventh_balance += $backlog->amount;
				   	}elseif ($backlog->concept_id == $organization->eighth_id) {
				   			$property->eighth_balance += $backlog->amount;
				   	}elseif ($backlog->concept_id == $organization->nineth_id) {
				   			$property->nineth_balance += $backlog->amount;
				   	}else {
				   			$property->tenth_balance += $backlog->amount;
				   	}
				   	$backlog->delete();
				}
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->property_id = $_POST['newPropertyId'];
			   	$answer->payment_date = $_POST['newPaymentDate'];
			   	$answer->organization_code = $organization->code;
			   	$answer->property_number = $property->apartment;
			   	$answer->amount = $_POST['newAmount'];
			   	$answer->applied = 1;
			   	$answer->ref_document = $_POST['newRefDocument'];
			   if ($answer->save()) {
			   	date_default_timezone_set('America/Bogota');
			   	$month = date('m');
			   	$bill = adminph\Bill::where('property_id',$answer->property_id)->whereMonth('created_at',$month)->orderBy('id','desc')->first();
			   	if ($bill->applied == 1) {
			   		$bill->first_concept = 0;
			   		$bill->second_concept = 0;
			   		$bill->third_concept = 0;
			   		$bill->fourth_concept = 0;
			   		$bill->fifth_concept = 0;
			   		$bill->sixth_concept = 0;
			   		$bill->seventh_concept = 0;
			   		$bill->eighth_concept = 0;
			   		$bill->nineth_concept = 0;
			   		$bill->tenth_concept = 0;
			   	}
			   	$admon = adminph\Concept::where('name','Cuota ordinaria')->first();
			   	$notaCredito = adminph\Concept::where('name','Nota credito')->first();
			   	$close = 'Y-m-'.$organization->discount_day;
				$factor= -1;
			   	if ($notaCredito->id == $organization->first_id) {
			   			$bill->first_concept *= $factor;
			   			$property->first_balance *= $factor;
			   	}elseif ($notaCredito->id == $organization->second_id) {
			   			$property->second_balance *= $factor;
			   			$bill->second_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->third_id) {
			   			$property->third_balance *= $factor;
			   			$bill->third_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->fourth_id) {
			   			$property->fourth_balance *= $factor;
			   			$bill->fourth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->fifth_id) {
			   			$property->fifth_balance *= $factor;
			   			$bill->fifth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->sixth_id) {
			   			$property->sixth_balance *= $factor;
			   			$bill->sixth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->seventh_id) {
			   			$property->seventh_balance *= $factor;
			   			$bill->seventh_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->eighth_id) {
			   			$property->eighth_balance *= $factor;
			   			$bill->eighth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->nineth_id) {
			   			$property->nineth_balance *= $factor;
			   			$bill->nineth_concept *= $factor;
			   	}else {
			   			$property->tenth_balance *= $factor;
			   			$bill->tenth_concept *= $factor;
			   	}
				$credit = $answer->amount;
			   	if (strtotime($answer->payment_date)<=strtotime(date($close))) {
			   		if ($bill->applied != 1) {
			   			$credit += $bill->discount;
						$log= new adminph\Backlog();
						$log->property_id=$property->id;
						$log->payment_id=$answer->id;
						$log->concept_id=$admon->id;
						$log->amount=(-1)*$bill->discount;
						$log->payment_date=$answer->payment_date;
						$log->save();
			   			$discount = adminph\Concept::where('name','Descuento')->first();
						$discountDoc = new adminph\Document();
						$discountDoc->concept_id = $discount->id;
						$discountDoc->property_id = $property->id;
						$discountDoc->organization_id = $organization->id;
						$discountDoc->date=$answer->payment_date;
						$discountDoc->body = "Descuento correspondiente al mes ".date('m/Y');
						$discountDoc->amount = $bill->discount;
						$lastDoc = adminph\Document::where('concept_id',$discount->id)->where('organization_id',$organization->id)->orderBy('number','desc')->first();
						if ($lastDoc != null && $lastDoc != "") {
							$docNumber=$lastDoc->number+1;
						}else{
							$docNumber=1;
						}
						$discountDoc->number = $docNumber;
						$discountDoc->save();
			   		}
				}
				$total = $bill->first_concept + $property->first_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->first_id;
				   	if ($notaCredito->id == $organization->first_id) {
				   		$log->amount = $property->first_balance;
				   	}else{
						$log->amount=$total;
					}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->first_balance=0;
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->first_id;
				   	if ($notaCredito->id == $organization->first_id) {
				   		$log->amount = $property->first_balance;
				   	}else{
						$log->amount=$credit;
					}	
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->first_balance=$total;
				}else{
					$property->first_balance=$total;
				}
				$total = $bill->second_concept + $property->second_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->second_id;
				   	if ($notaCredito->id == $organization->second_id) {
				   		$log->amount = $property->second_balance;
				   	}else{
						$log->amount=$total;
					}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->second_balance=0;
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->second_id;
				   	if ($notaCredito->id == $organization->second_id) {
				   		$log->amount = $property->second_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->second_balance=$total;
				}else{
					$property->second_balance=$total;
				}
				$total = $bill->third_concept + $property->third_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->third_id;
				   	if ($notaCredito->id == $organization->third_id) {
				   		$log->amount = $property->third_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->third_balance=0;
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->third_id;
				   	if ($notaCredito->id == $organization->third_id) {
				   		$log->amount = $property->third_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->third_balance=$total;
				}else{
					$property->third_balance=$total;
				}
				$total = $bill->fourth_concept + $property->fourth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fourth_id;
				   	if ($notaCredito->id == $organization->fourth_id) {
				   		$log->amount = $property->fourth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->fourth_balance=0;
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fourth_id;
				   	if ($notaCredito->id == $organization->fourth_id) {
				   		$log->amount = $property->fourth_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->fourth_balance=$total;
				}else{
					$property->fourth_balance=$total;
				}
				$total = $bill->fifth_concept + $property->fifth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fifth_id;
				   	if ($notaCredito->id == $organization->fifth_id) {
				   		$log->amount = $property->fifth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->fifth_balance=0;
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fifth_id;
					$log->concept_id=$organization->fifth_id;
				   	if ($notaCredito->id == $organization->fifth_id) {
				   		$log->amount = $property->fifth_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->fifth_balance=$total;
				}else{
					$property->fifth_balance=$total;
				}
				$total = $bill->sixth_concept + $property->sixth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->sixth_id;
					$log->concept_id=$organization->sixth_id;
				   	if ($notaCredito->id == $organization->sixth_id) {
				   		$log->amount = $property->sixth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->sixth_balance=0;
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->sixth_id;
				   	if ($notaCredito->id == $organization->sixth_id) {
				   		$log->amount = $property->sixth_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->sixth_balance=$total;
				}else{
					$property->sixth_balance=$total;
				}
				$total = $bill->seventh_concept + $property->seventh_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->seventh_id;
				   	if ($notaCredito->id == $organization->seventh_id) {
				   		$log->amount = $property->seventh_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->seventh_balance=0;
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->seventh_id;
				   	if ($notaCredito->id == $organization->seventh_id) {
				   		$log->amount = $property->seventh_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->seventh_balance=$total;
				}else{
					$property->seventh_balance=$total;
				}
				$total = $bill->eighth_concept + $property->eighth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->eighth_id;
				   	if ($notaCredito->id == $organization->eighth_id) {
				   		$log->amount = $property->eighth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->eighth_balance=0;
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->eighth_id;
				   	if ($notaCredito->id == $organization->eighth_id) {
				   		$log->amount = $property->eighth_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->eighth_balance=$total;
				}else{
					$property->eighth_balance=$total;
				}
				$total = $bill->nineth_concept + $property->nineth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->nineth_id;
				   	if ($notaCredito->id == $organization->nineth_id) {
				   		$log->amount = $property->nineth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->nineth_balance=0;
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->nineth_id;
				   	if ($notaCredito->id == $organization->nineth_id) {
				   		$log->amount = $property->nineth_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->nineth_balance=$total;
				}else{
					$property->nineth_balance=$total;
				}
				$total = $bill->tenth_concept + $property->tenth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->tenth_id;
				   	if ($notaCredito->id == $organization->tenth_id) {
				   		$log->amount = $property->tenth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->tenth_balance=0;
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->tenth_id;
				   	if ($notaCredito->id == $organization->tenth_id) {
				   		$log->amount = $property->tenth_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->tenth_balance=$total;
				}else{
					$property->tenth_balance=$total;
				}
				if ($credit>0) {
					if ($organization->first_id==$notaCredito->id) {
						$property->first_balance += $credit;
					}else{
						$property->first_balance -= $credit;
					}
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->first_id;
					$log->amount=$credit;
					$log->payment_date=$answer->payment_date;
					$log->save();
				}
				$property->save();
			   	if ($bill->applied != 1) {
					$bill->applied = 1;
					$bill->save();
				}
			   	return redirect('pagos');
			   }
			 } else {
			 	return view('layouts.payments_error');
			 }
		}

	}
	/*======================================
	=            Borrar Pago            =
	======================================*/
	static public function ctrBorrarPago(){
		if (isset($_POST['idPago'])) {
		$answer=adminph\Payment::find($_POST['idPago']);
		$backlogs = $answer->backlogs;
		$property = $answer->property;
		$organization = $property->organization;
	   	$month = $answer->payment_date->format('m');
	   	$year = $answer->payment_date->format('Y');
		$discount = adminph\Concept::where('name','Descuento')->first();
		$discountDoc = adminph\Document::where('property_id',$property->id)->where('concept_id',$discount->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->first();
		$discountDoc->delete();
		$creditNote = adminph\Concept::where('name','Nota credito')->first();
		$bill = adminph\Bill::where('property_id',$property->id)->orderBy('created_at','desc')->first();
		foreach ($backlogs as $key => $backlog) {
			$concept = $backlog->concept;
			if ($concept->name=='Nota crédito') {
				$backlog->amount *= -1;
			}
		   	if ($backlog->concept_id == $organization->first_id) {
		   			$property->first_balance += $backlog->amount;
		   			if ($organization->first_id != $creditNote->id) {
		   				$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->first_id;
						$note->amount=$backlog->amount;
						$note->save();
		   			}
		   	}elseif ($backlog->concept_id == $organization->second_id) {
		   			$property->second_balance += $backlog->amount;
		   			if ($organization->second_id != $creditNote->id) {
		   				$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->second_id;
						$note->amount=$backlog->amount;
						$note->save();
		   			}
		   	}elseif ($backlog->concept_id == $organization->third_id) {
		   			$property->third_balance += $backlog->amount;
		   			if ($organization->third_id != $creditNote->id) {
		   				$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->third_id;
						$note->amount=$backlog->amount;
						$note->save();
		   			}
		   	}elseif ($backlog->concept_id == $organization->fourth_id) {
		   			$property->fourth_balance += $backlog->amount;
		   			if ($organization->fourth_id != $creditNote->id) {
		   				$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->fourth_id;
						$note->amount=$backlog->amount;
						$note->save();
		   			}
		   	}elseif ($backlog->concept_id == $organization->fifth_id) {
		   			$property->fifth_balance += $backlog->amount;
		   			if ($organization->fifth_id != $creditNote->id) {
		   				$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->fifth_id;
						$note->amount=$backlog->amount;
						$note->save();
		   			}
		   	}elseif ($backlog->concept_id == $organization->sixth_id) {
		   			$property->sixth_balance += $backlog->amount;
		   			if ($organization->sixth_id != $creditNote->id) {
		   				$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->sixth_id;
						$note->amount=$backlog->amount;
						$note->save();
		   			}
		   	}elseif ($backlog->concept_id == $organization->seventh_id) {
		   			$property->seventh_balance += $backlog->amount;
		   			if ($organization->seventh_id != $creditNote->id) {
		   				$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->seventh_id;
						$note->amount=$backlog->amount;
						$note->save();
		   			}
		   	}elseif ($backlog->concept_id == $organization->eighth_id) {
		   			$property->eighth_balance += $backlog->amount;
		   			if ($organization->eighth_id != $creditNote->id) {
		   				$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->eighth_id;
						$note->amount=$backlog->amount;
						$note->save();
		   			}
		   	}elseif ($backlog->concept_id == $organization->nineth_id) {
		   			$property->nineth_balance += $backlog->amount;
		   			if ($organization->nineth_id != $creditNote->id) {
		   				$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->nineth_id;
						$note->amount=$backlog->amount;
						$note->save();
		   			}
		   	}else {
		   			$property->tenth_balance += $backlog->amount;
		   			if ($organization->tenth_id != $creditNote->id) {
		   				$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->tenth_id;
						$note->amount=$backlog->amount;
						$note->save();
		   			}
		   	}
		   	$property->save();
		   	$backlog->delete();
		}
		$answer->delete();
		}
	}
	/*======================================
	=           Subir pagos          =
	======================================*/
	static public function ctrSubirPagos(){
		$handle = fopen($_FILES['pagos']['tmp_name'], "r");

		while ($csvLine = fgetcsv($handle, 1000, ";")) {
				$csvLine = array_map("utf8_encode", $csvLine); //added
			   	$organization = adminph\Organization::where('code',$csvLine[0])->first();
			   	$property = adminph\Property::where('organization_id',$organization->id)->where('apartment',$csvLine[1])->first();
				if (is_object($organization) && is_object($property)) {
					$lastPayment = adminph\Payment::where('organization_id',$_POST['newOrganizationId'])->orderBy('created_at','desc')->first();
				   	$answer = new adminph\Payment();
					if (is_object($lastPayment)) {
						$answer->number = $lastPayment->number + 1;	
					}else{
						$answer->number = 1;
					}
				   	$answer->organization_id = $organization->id;
				   	$answer->property_id = $property->id;
				   	$answer->payment_date = $csvLine[4];
				   	$answer->organization_code = $organization->code;
				   	$answer->property_number = $property->apartment;
				   	$answer->amount = $csvLine[2];
				   	$answer->applied = 1;
				   	$answer->ref_document = $csvLine[3];
				   if ($answer->save()) {
			   	date_default_timezone_set('America/Bogota');
			   	$month = date('m');
			   	$bill = adminph\Bill::where('property_id',$answer->property_id)->whereMonth('created_at',$month)->orderBy('id','desc')->first();
			   	if ($bill->applied == 1) {
			   		$bill->first_concept = 0;
			   		$bill->second_concept = 0;
			   		$bill->third_concept = 0;
			   		$bill->fourth_concept = 0;
			   		$bill->fifth_concept = 0;
			   		$bill->sixth_concept = 0;
			   		$bill->seventh_concept = 0;
			   		$bill->eighth_concept = 0;
			   		$bill->nineth_concept = 0;
			   		$bill->tenth_concept = 0;
			   	}
			   	$admon = adminph\Concept::where('name','Cuota ordinaria')->first();
			   	$notaCredito = adminph\Concept::where('name','Nota credito')->first();
			   	$close = 'Y-m-'.$organization->discount_day;
				$factor= -1;
			   	if ($notaCredito->id == $organization->first_id) {
			   			$bill->first_concept *= $factor;
			   			$property->first_balance *= $factor;
			   	}elseif ($notaCredito->id == $organization->second_id) {
			   			$property->second_balance *= $factor;
			   			$bill->second_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->third_id) {
			   			$property->third_balance *= $factor;
			   			$bill->third_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->fourth_id) {
			   			$property->fourth_balance *= $factor;
			   			$bill->fourth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->fifth_id) {
			   			$property->fifth_balance *= $factor;
			   			$bill->fifth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->sixth_id) {
			   			$property->sixth_balance *= $factor;
			   			$bill->sixth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->seventh_id) {
			   			$property->seventh_balance *= $factor;
			   			$bill->seventh_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->eighth_id) {
			   			$property->eighth_balance *= $factor;
			   			$bill->eighth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->nineth_id) {
			   			$property->nineth_balance *= $factor;
			   			$bill->nineth_concept *= $factor;
			   	}else {
			   			$property->tenth_balance *= $factor;
			   			$bill->tenth_concept *= $factor;
			   	}
				$credit = $answer->amount;
			   	if (strtotime($answer->payment_date)<=strtotime(date($close))) {
			   		if ($bill->applied != 1) {
			   			$credit += $bill->discount;
						$log= new adminph\Backlog();
						$log->property_id=$property->id;
						$log->payment_id=$answer->id;
						$log->concept_id=$admon->id;
						$log->amount=(-1)*$bill->discount;
						$log->payment_date=$answer->payment_date;
						$log->save();
			   			$discount = adminph\Concept::where('name','Descuento')->first();
						$discountDoc = new adminph\Document();
						$discountDoc->concept_id = $discount->id;
						$discountDoc->property_id = $property->id;
						$discountDoc->organization_id = $organization->id;
						$discountDoc->date=$answer->payment_date;
						$discountDoc->body = "Descuento correspondiente al mes ".date('m/Y');
						$discountDoc->amount = $bill->discount;
						$lastDoc = adminph\Document::where('concept_id',$discount->id)->where('organization_id',$organization->id)->orderBy('number','desc')->first();
						if ($lastDoc != null && $lastDoc != "") {
							$docNumber=$lastDoc->number+1;
						}else{
							$docNumber=1;
						}
						$discountDoc->number = $docNumber;
						$discountDoc->save();
			   		}
				}
				$total = $bill->first_concept + $property->first_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->first_id;
				   	if ($notaCredito->id == $organization->first_id) {
				   		$log->amount = $property->first_balance;
				   	}else{
						$log->amount=$total;
					}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->first_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->first_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->first_id;
				   	if ($notaCredito->id == $organization->first_id) {
				   		$log->amount = $property->first_balance;
				   	}else{
						$log->amount=$credit;
						$credit2=$credit;
						$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->first_id)->orderBy('created_at','asc')->get();
						if (!$oldNotes->isEmpty()) {
							foreach ($oldNotes as $oldNote) {
								if ($credit2 >= $oldNote->amount) {
									$credit2 -= $oldNote->amount;
									$oldNote->delete();
								}elseif ($credit2 > 0) {
									$oldNote->amount -= $credit2;
									$oldNote->save();
									$credit2 = 0;
								}
							}
						}
						if ($credit2 > 0) {
							$amount = $bill->first_concept-$credit2;
							$note = new adminph\Note();
							$note->property_id=$property->id;
							$note->bill_id=$bill->id;
							$note->concept_id=$organization->first_id;
							$note->amount=$amount;
							$note->save();
							$credit2 = 0;
						}
					}	
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->first_balance=$total;
				}else{
					$property->first_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->first_id;
					$note->amount=$bill->first_balance;
					$note->save();
				}
				$total = $bill->second_concept + $property->second_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->second_id;
				   	if ($notaCredito->id == $organization->second_id) {
				   		$log->amount = $property->second_balance;
				   	}else{
						$log->amount=$total;
					}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->second_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->second_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->second_id;
				   	if ($notaCredito->id == $organization->second_id) {
				   		$log->amount = $property->second_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->second_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->second_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->second_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->second_balance=$total;
				}else{
					$property->second_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->second_id;
					$note->amount=$bill->second_balance;
					$note->save();
				}
				$total = $bill->third_concept + $property->third_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->third_id;
				   	if ($notaCredito->id == $organization->third_id) {
				   		$log->amount = $property->third_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->third_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->third_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->third_id;
				   	if ($notaCredito->id == $organization->third_id) {
				   		$log->amount = $property->third_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->third_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->third_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->third_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->third_balance=$total;
				}else{
					$property->third_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->third_id;
					$note->amount=$bill->third_balance;
					$note->save();
				}
				$total = $bill->fourth_concept + $property->fourth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fourth_id;
				   	if ($notaCredito->id == $organization->fourth_id) {
				   		$log->amount = $property->fourth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->fourth_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->fourth_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fourth_id;
				   	if ($notaCredito->id == $organization->fourth_id) {
				   		$log->amount = $property->fourth_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->fourth_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->fourth_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->fourth_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->fourth_balance=$total;
				}else{
					$property->fourth_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->fourth_id;
					$note->amount=$bill->fourth_balance;
					$note->save();
				}
				$total = $bill->fifth_concept + $property->fifth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fifth_id;
				   	if ($notaCredito->id == $organization->fifth_id) {
				   		$log->amount = $property->fifth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->fifth_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->fifth_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fifth_id;
					$log->concept_id=$organization->fifth_id;
				   	if ($notaCredito->id == $organization->fifth_id) {
				   		$log->amount = $property->fifth_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->fifth_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->fifth_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->fifth_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->fifth_balance=$total;
				}else{
					$property->fifth_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->fifth_id;
					$note->amount=$bill->fifth_balance;
					$note->save();
				}
				$total = $bill->sixth_concept + $property->sixth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->sixth_id;
					$log->concept_id=$organization->sixth_id;
				   	if ($notaCredito->id == $organization->sixth_id) {
				   		$log->amount = $property->sixth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->sixth_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->sixth_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->sixth_id;
				   	if ($notaCredito->id == $organization->sixth_id) {
				   		$log->amount = $property->sixth_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->sixth_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->sixth_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->sixth_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->sixth_balance=$total;
				}else{
					$property->sixth_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->sixth_id;
					$note->amount=$bill->sixth_balance;
					$note->save();
				}
				$total = $bill->seventh_concept + $property->seventh_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->seventh_id;
				   	if ($notaCredito->id == $organization->seventh_id) {
				   		$log->amount = $property->seventh_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->seventh_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->seventh_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->seventh_id;
				   	if ($notaCredito->id == $organization->seventh_id) {
				   		$log->amount = $property->seventh_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->seventh_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->seventh_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->seventh_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->seventh_balance=$total;
				}else{
					$property->seventh_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->seventh_id;
					$note->amount=$bill->seventh_balance;
					$note->save();
				}
				$total = $bill->eighth_concept + $property->eighth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->eighth_id;
				   	if ($notaCredito->id == $organization->eighth_id) {
				   		$log->amount = $property->eighth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->eighth_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->eighth_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->eighth_id;
				   	if ($notaCredito->id == $organization->eighth_id) {
				   		$log->amount = $property->eighth_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->eighth_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->eighth_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->eighth_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->eighth_balance=$total;
				}else{
					$property->eighth_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->eighth_id;
					$note->amount=$bill->eighth_balance;
					$note->save();
				}
				$total = $bill->nineth_concept + $property->nineth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->nineth_id;
				   	if ($notaCredito->id == $organization->nineth_id) {
				   		$log->amount = $property->nineth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->nineth_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->nineth_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->nineth_id;
				   	if ($notaCredito->id == $organization->nineth_id) {
				   		$log->amount = $property->nineth_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->nineth_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->nineth_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->nineth_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->nineth_balance=$total;
				}else{
					$property->nineth_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->nineth_id;
					$note->amount=$bill->nineth_balance;
					$note->save();
				}
				$total = $bill->tenth_concept + $property->tenth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->tenth_id;
				   	if ($notaCredito->id == $organization->tenth_id) {
				   		$log->amount = $property->tenth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$property->tenth_balance=0;
					$notes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->tenth_id)->orderBy('created_at','asc')->get();
					if (!$notes->isEmpty()) {
						foreach ($notes as $note) {
							$note->delete();
						}
					}
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->tenth_id;
				   	if ($notaCredito->id == $organization->tenth_id) {
				   		$log->amount = $property->tenth_balance;
				   	}else{
					$log->amount=$credit;
					$credit2=$credit;
					$oldNotes = adminph\Note::where('property_id',$property->id)->where('concept_id',$organization->tenth_id)->orderBy('created_at','asc')->get();
					if (!$oldNotes->isEmpty()) {
						foreach ($oldNotes as $oldNote) {
							if ($credit2 >= $oldNote->amount) {
								$credit2 -= $oldNote->amount;
								$oldNote->delete();
							}elseif ($credit2 > 0) {
								$oldNote->amount -= $credit2;
								$oldNote->save();
								$credit2 = 0;
							}
						}
					}
					if ($credit2 > 0) {
						$amount = $bill->tenth_concept-$credit2;
						$note = new adminph\Note();
						$note->property_id=$property->id;
						$note->bill_id=$bill->id;
						$note->concept_id=$organization->tenth_id;
						$note->amount=$amount;
						$note->save();
						$credit2 = 0;
					}
				}
					$log->payment_date=$answer->payment_date;
					$log->save();
					$total -= $credit;
					$credit = 0;
					$property->tenth_balance=$total;
				}else{
					$property->tenth_balance=$total;
					$note = new adminph\Note();
					$note->property_id=$property->id;
					$note->bill_id=$bill->id;
					$note->concept_id=$organization->tenth_id;
					$note->amount=$bill->tenth_balance;
					$note->save();
				}
				if ($credit>0) {
					if ($organization->first_id==$notaCredito->id) {
						$property->first_balance += $credit;
					}else{
						$property->first_balance -= $credit;
					}
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->first_id;
					$log->amount=$credit;
					$log->payment_date=$answer->payment_date;
					$log->save();
				}
				$property->save();
			   	if ($bill->applied != 1) {
					$bill->applied = 1;
					$bill->save();
				}
				   }
		    }
		}
		
	   	return redirect('pagos');

	}
	/*======================================
	=           Subir pagos          =
	======================================*/
	static public function ctrPagosViejos(){
		$handle = fopen($_FILES['pagos']['tmp_name'], "r");

		while ($csvLine = fgetcsv($handle, 1000, ";")) {
				$csvLine = array_map("utf8_encode", $csvLine); //added
			   	$organization = adminph\Organization::where('code',$csvLine[0])->first();
			   	$property = adminph\Property::where('organization_id',$organization->id)->where('apartment',$csvLine[1])->first();
				if (is_object($organization) && is_object($property)) {
				   	$answer = new adminph\Payment();
				   	$answer->organization_id = $organization->id;
				   	$answer->property_id = $property->id;
				   	$answer->payment_date = $csvLine[4];
				   	$answer->number = $csvLine[5];
				   	$answer->organization_code = $organization->code;
				   	$answer->property_number = $property->apartment;
				   	$answer->amount = $csvLine[2];
				   	$answer->applied = 1;
				   	$answer->ref_document = $csvLine[3];
					$answer->created_at = date($csvLine[4].' 00:00:01');
				   if ($answer->save()) {
			   	date_default_timezone_set('America/Bogota');
			   	$month = date(substr($csvLine[4],5,2));
			   	$bill = adminph\Bill::where('property_id',$answer->property_id)->whereMonth('created_at',$month)->orderBy('id','desc')->first();
			   	$admon = adminph\Concept::where('name','Cuota ordinaria')->first();
			   	$notaCredito = adminph\Concept::where('name','Nota credito')->first();
			   	$close = $bill->discount_date;
				$factor= -1;
			   	if ($notaCredito->id == $organization->first_id) {
			   			$bill->first_concept *= $factor;
			   			$bill->first_balance *= $factor;
			   	}elseif ($notaCredito->id == $organization->second_id) {
			   			$bill->second_balance *= $factor;
			   			$bill->second_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->third_id) {
			   			$bill->third_balance *= $factor;
			   			$bill->third_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->fourth_id) {
			   			$bill->fourth_balance *= $factor;
			   			$bill->fourth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->fifth_id) {
			   			$bill->fifth_balance *= $factor;
			   			$bill->fifth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->sixth_id) {
			   			$bill->sixth_balance *= $factor;
			   			$bill->sixth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->seventh_id) {
			   			$bill->seventh_balance *= $factor;
			   			$bill->seventh_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->eighth_id) {
			   			$bill->eighth_balance *= $factor;
			   			$bill->eighth_concept *= $factor;
			   	}elseif ($notaCredito->id == $organization->nineth_id) {
			   			$bill->nineth_balance *= $factor;
			   			$bill->nineth_concept *= $factor;
			   	}else {
			   			$bill->tenth_balance *= $factor;
			   			$bill->tenth_concept *= $factor;
			   	}
				$credit = $answer->amount;
			   	if (strtotime($answer->payment_date)<=strtotime(date($close))) {
			   			$credit += $bill->discount;
						$log= new adminph\Backlog();
						$log->property_id=$property->id;
						$log->payment_id=$answer->id;
						$log->concept_id=$admon->id;
						$log->amount=(-1)*$bill->discount;
						$log->payment_date=$answer->payment_date;
						$log->created_at = date($csvLine[4].' 00:00:01');
						$log->save();
			   			$discount = adminph\Concept::where('name','Descuento')->first();
						$discountDoc = new adminph\Document();
						$discountDoc->concept_id = $discount->id;
						$discountDoc->property_id = $property->id;
						$discountDoc->organization_id = $organization->id;
						$discountDoc->$answer->payment_date;
						$discountDoc->body = "Descuento correspondiente al mes ".date('m/Y');
						$discountDoc->amount = $bill->discount;
						$docNumber=1;
						$discountDoc->number = $docNumber;
						$discountDoc->created_at = date($csvLine[4].' 00:00:01');
						$discountDoc->save();
				}
				$total = $bill->first_concept + $bill->first_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->first_id;
				   	if ($notaCredito->id == $organization->first_id) {
				   		$log->amount = $bill->first_balance;
				   	}else{
						$log->amount=$total;
					}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->first_id;
				   	if ($notaCredito->id == $organization->first_id) {
				   		$log->amount = $bill->first_balance;
				   	}else{
						$log->amount=$credit;
					}	
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
					$total -= $credit;
					$credit = 0;
				}
				$total = $bill->second_concept + $bill->second_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->second_id;
				   	if ($notaCredito->id == $organization->second_id) {
				   		$log->amount = $bill->second_balance;
				   	}else{
						$log->amount=$total;
					}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->second_id;
				   	if ($notaCredito->id == $organization->second_id) {
				   		$log->amount = $bill->second_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
					$total -= $credit;
					$credit = 0;
				}
				$total = $bill->third_concept + $bill->third_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->third_id;
				   	if ($notaCredito->id == $organization->third_id) {
				   		$log->amount = $bill->third_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->third_id;
				   	if ($notaCredito->id == $organization->third_id) {
				   		$log->amount = $bill->third_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
					$total -= $credit;
					$credit = 0;
				}
				$total = $bill->fourth_concept + $bill->fourth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fourth_id;
				   	if ($notaCredito->id == $organization->fourth_id) {
				   		$log->amount = $bill->fourth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fourth_id;
				   	if ($notaCredito->id == $organization->fourth_id) {
				   		$log->amount = $bill->fourth_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
					$total -= $credit;
					$credit = 0;
				}
				$total = $bill->fifth_concept + $bill->fifth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fifth_id;
				   	if ($notaCredito->id == $organization->fifth_id) {
				   		$log->amount = $bill->fifth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->fifth_id;
					$log->concept_id=$organization->fifth_id;
				   	if ($notaCredito->id == $organization->fifth_id) {
				   		$log->amount = $bill->fifth_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
					$total -= $credit;
					$credit = 0;
				}
				$total = $bill->sixth_concept + $bill->sixth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->sixth_id;
					$log->concept_id=$organization->sixth_id;
				   	if ($notaCredito->id == $organization->sixth_id) {
				   		$log->amount = $bill->sixth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->sixth_id;
				   	if ($notaCredito->id == $organization->sixth_id) {
				   		$log->amount = $bill->sixth_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
					$total -= $credit;
					$credit = 0;
				}
				$total = $bill->seventh_concept + $bill->seventh_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->seventh_id;
				   	if ($notaCredito->id == $organization->seventh_id) {
				   		$log->amount = $bill->seventh_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->seventh_id;
				   	if ($notaCredito->id == $organization->seventh_id) {
				   		$log->amount = $bill->seventh_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
					$total -= $credit;
					$credit = 0;
				}
				$total = $bill->eighth_concept + $bill->eighth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->eighth_id;
				   	if ($notaCredito->id == $organization->eighth_id) {
				   		$log->amount = $bill->eighth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->eighth_id;
				   	if ($notaCredito->id == $organization->eighth_id) {
				   		$log->amount = $bill->eighth_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
					$total -= $credit;
					$credit = 0;
				}
				$total = $bill->nineth_concept + $bill->nineth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->nineth_id;
				   	if ($notaCredito->id == $organization->nineth_id) {
				   		$log->amount = $bill->nineth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->nineth_id;
				   	if ($notaCredito->id == $organization->nineth_id) {
				   		$log->amount = $bill->nineth_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
					$total -= $credit;
					$credit = 0;
				}
				$total = $bill->tenth_concept + $bill->tenth_balance;
				if ($credit>=$total) {
					$credit-=$total;
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->tenth_id;
				   	if ($notaCredito->id == $organization->tenth_id) {
				   		$log->amount = $bill->tenth_balance;
				   	}else{
					$log->amount=$total;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
				}elseif ($credit<$total && $credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->tenth_id;
				   	if ($notaCredito->id == $organization->tenth_id) {
				   		$log->amount = $bill->tenth_balance;
				   	}else{
					$log->amount=$credit;
				}
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
					$total -= $credit;
					$credit = 0;
				}
				if ($credit>0) {
					$log= new adminph\Backlog();
					$log->property_id=$property->id;
					$log->payment_id=$answer->id;
					$log->concept_id=$organization->first_id;
					$log->amount=$credit;
					$log->payment_date=$answer->payment_date;
					$log->created_at = date($csvLine[4].' 00:00:01');
					$log->save();
				}
				   }
		    }
		}
		
	   	return redirect('pagos');

	}
	public function ajaxEditarPago(){
		$answer = adminph\Payment::find($_POST['idPago']);
		echo json_encode($answer);
	} 
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatablePagos()
	{	
	if (session('rank')=='Admin') {
  		$productos = adminph\Payment::all();
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
	  $productos = adminph\Payment::where('property_id',$answer->property_id)->get();
	}

  	echo '{
			"data": [';
			$buttons="";

			for($i = 0; $i < count($productos)-1; $i++){
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><button class='btn btn-warning btnEditarPago' idPago='".$productos[$i]->id."' data-toggle='modal' data-target='#modalEditarPago'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarPago' idPago='".$productos[$i]->id."'><i class='fa fa-times'></i></button></div>";
                }
				 echo '[
			      "'.($i+1).'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->property->apartment.'",
			      "'.$productos[$i]->amount.'",
			      "'.$productos[$i]->ref_document.'",
			      "'.$productos[$i]->payment_date.'",
			      "'.$buttons.'"
			    ],';

			}
			$buttons="";
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><button class='btn btn-warning btnEditarPago' idPago='".$productos[count($productos)-1]->id."' data-toggle='modal' data-target='#modalEditarPago'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarPago' idPago='".$productos[count($productos)-1]->id."'><i class='fa fa-times'></i></button></div>";
                }
				 echo '[
			      "'.(count($productos)).'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->property->apartment.'",
			      "'.$productos[count($productos)-1]->amount.'",
			      "'.$productos[count($productos)-1]->ref_document.'",
			      "'.$productos[count($productos)-1]->payment_date.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
}
