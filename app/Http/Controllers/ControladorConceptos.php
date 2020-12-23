<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use adminph;

class ControladorConceptos extends Controller
{
    /*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearConcepto(){

		if (isset($_POST['newConcept'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"])) {
			   	$answer = new adminph\Concept();
			   	$answer->name = $_POST['newName'];
			   	$answer->priority = $_POST['newPriority'];
			   	$answer->charge = $_POST['newCharge'];
			   if ($answer->save()) {
			   	return redirect('conceptos');
			   }
			 } else {
			 	return view('layouts.concepts_error');
			 }
		}

	}
	/*===================================
	=            USER EDIT            =
	===================================*/
	
	static public function ctrEditarConcepto(){

		if (isset($_POST['editConcept'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"])) {
				$answer = adminph\Concept::find($_POST['editId']);
			   	$answer->name = $_POST['newName'];
			   	$answer->priority = $_POST['newPriority'];
			   	$answer->charge = $_POST['newCharge'];
			   if ($answer->save()) {
			   	return redirect('conceptos');			   
			   }
			 } else {
			 	return view('layouts.concepts_error');
			 }
		}

	}
	/*======================================
	=            Borrar Concepto            =
	======================================*/
	static public function ctrBorrarConcepto(){
		if (isset($_POST['idConcepto'])) {
		$answer=adminph\Concept::find($_POST['idConcepto']);
		$answer->delete();
		}
	}
	public function ajaxEditarConcepto(){
		$answer = adminph\Concept::find($_POST['idConcepto']);
		echo json_encode($answer);
	} 
	public function ajaxCheckearConcepto(){
		$answer = adminph\Concept::where('name',$_POST['nombreConcepto'])->first();
		echo json_encode($answer);
	} 
}
