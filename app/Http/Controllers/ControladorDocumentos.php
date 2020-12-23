<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use adminph;

class ControladorDocumentos extends Controller
{
    /*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearDocumento(){

		if (isset($_POST['newDocument'])) {
			if (preg_match('/^[0-9.]+$/', $_POST["newAmount"])) {
			   	$answer = new adminph\Document();
			   	$answer->concept_id = $_POST['newConceptId'];
			   	$answer->property_id = $_POST['newPropertyId'];
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->date = date('Y-m-d');
			   	$answer->body = $_POST['newBody'];
			   	$answer->amount = $_POST['newAmount'];
				$lastDoc = adminph\Document::where('concept_id',$answer->concept_id)->where('organization_id',$answer->organization_id)->orderBy('number','desc')->first();
				if ($lastDoc != null && $lastDoc != "") {
					$docNumber=$lastDoc->number+1;
				}else{
					$docNumber=1;
				}
				$answer->number = $docNumber;
			   if ($answer->save()) {
			   	return redirect('documentos');
			   }
			 } else {
			 	return view('layouts.documents_error');
			 }
		}

	}
	/*===================================
	=            USER EDIT            =
	===================================*/
	
	static public function ctrEditarDocumento(){

		if (isset($_POST['editDocument'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newAmount"])) {
				$answer = adminph\Document::find($_POST['editId']);
			   	$answer->concept_id = $_POST['newConceptId'];
			   	$answer->property_id = $_POST['newPropertyId'];
			   	$answer->organization_id = $_POST['newOrganizationId'];
			   	$answer->body = $_POST['newBody'];
			   	$answer->amount = $_POST['newAmount'];
			   if ($answer->save()) {
			   	return redirect('documentos');			   
			   }
			 } else {
			 	return view('layouts.documents_error');
			 }
		}

	}
	/*======================================
	=            Borrar Documento            =
	======================================*/
	static public function ctrBorrarDocumento(){
		if (isset($_POST['idDocumento'])) {
		$answer=adminph\Document::find($_POST['idDocumento']);
		$answer->delete();
		}
	}
	public function ajaxEditarDocumento(){
		$answer = adminph\Document::find($_POST['idDocumento']);
		echo json_encode($answer);
	} 
	/*======================================
	=           Subir propiedades          =
	======================================*/
	static public function ctrSubirDocumentos(){
		$handle = fopen($_FILES['documentos']['tmp_name'], "r");

		while ($csvLine = fgetcsv($handle, 1000, ";")) {
				$csvLine = array_map("utf8_encode", $csvLine); //added
			   	$organization = adminph\Organization::where('code',$csvLine[1])->first();
			   	$property = adminph\Property::where('organization_id',$organization->id)->where('apartment',$csvLine[2])->first();
			   	$concept = adminph\Concept::where('name',$csvLine[0])->first();
				if (is_object($organization) && is_object($property) && is_object($concept)) {
					$answer = new adminph\Document();
				   	$answer->concept_id = $concept->id;
				   	$answer->property_id = $property->id;
				   	$answer->organization_id = $organization->id;
				   	$answer->date = date($csvLine[3]);
				   	$answer->body = $csvLine[4];
				   	$answer->amount = $csvLine[5];
					$lastDoc = adminph\Document::where('concept_id',$answer->concept_id)->where('organization_id',$answer->organization_id)->orderBy('number','desc')->first();
					if ($lastDoc != null && $lastDoc != "") {
						$docNumber=$lastDoc->number+1;
					}else{
						$docNumber=1;
					}
					$answer->number = $docNumber;
					$answer->save();
		    	}
		}
		
	   	return redirect('documentos');

	}
	/*======================================
	=           Subir propiedades          =
	======================================*/
	static public function ctrDocumentosViejos(){
		$handle = fopen($_FILES['documentos']['tmp_name'], "r");

		while ($csvLine = fgetcsv($handle, 1000, ";")) {
				$csvLine = array_map("utf8_encode", $csvLine); //added
			   	$organization = adminph\Organization::where('code',$csvLine[1])->first();
			   	$property = adminph\Property::where('organization_id',$organization->id)->where('apartment',$csvLine[2])->first();
			   	$concept = adminph\Concept::where('name',$csvLine[0])->first();
				if (is_object($organization) && is_object($property) && is_object($concept)) {
					$answer = new adminph\Document();
				   	$answer->concept_id = $concept->id;
				   	$answer->property_id = $property->id;
				   	$answer->organization_id = $organization->id;
				   	$answer->date = date($csvLine[3]);
				   	$answer->body = $csvLine[4];
				   	$answer->amount = $csvLine[5];
					$answer->number = $csvLine[6];
					$answer->created_at = date($csvLine[3].' 00:00:01');
					$answer->save();
		    	}
		}
		
	   	return redirect('documentos');

	}
	/*===============================================
	=            Mostrar tabla propiedades           =
	===============================================*/
	
	public function ajaxDatatableDocumentos()
	{	
	if (session('rank')=='Admin') {
  		$productos = adminph\Document::all();
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
	  $productos = adminph\Document::where('property_id',$answer->property_id)->get();
	}

  	echo '{
			"data": [';

			for($i = 0; $i < count($productos)-1; $i++){
				/*=============================
				=            Stock            =
				=============================*/
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><a href='clientes/documentos/".$productos[$i]->id."' target='_blank'><button class='btn btn-primary'><i class='far fa-eye'></i></button></a><button class='btn btn-warning btnEditarDocumento' idDocumento='".$productos[$i]->id."' data-toggle='modal' data-target='#modalEditarDocumento'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarDocumento' idDocumento='".$productos[$i]->id."'><i class='fa fa-times'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'><a href='clientes/documentos/".$productos[$i]->id."' target='_blank'><button class='btn btn-primary'><i class='far fa-eye'></i></button></a></div>";
                }
				 echo '[
			      "'.($i+1).'",
			      "'.$productos[$i]->number.'",
			      "'.$productos[$i]->concept->name.'",
			      "'.$productos[$i]->organization->code.'",
			      "'.$productos[$i]->property->apartment.'",
			      "'.$productos[$i]->date.'",
			      "'.$productos[$i]->amount.'",
			      "'.$buttons.'"
			    ],';

			}
				/*=============================
				=            Stock            =
				=============================*/
				if (session('rank')=='Admin') {
                    $buttons ="<div class='btn-group'><a href='clientes/documentos/".$productos[count($productos)-1]->id."' target='_blank'><button class='btn btn-primary'><i class='far fa-eye'></i></button></a><button class='btn btn-warning btnEditarDocumento' idDocumento='".$productos[count($productos)-1]->id."' data-toggle='modal' data-target='#modalEditarDocumento'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnBorrarDocumento' idDocumento='".$productos[count($productos)-1]->id."'><i class='fa fa-times'></i></button></div>";
                }else{
                    $buttons ="<div class='btn-group'><a href='clientes/documentos/".$productos[count($productos)-1]->id."' target='_blank'><button class='btn btn-primary'><i class='far fa-eye'></i></button></a></div>";
                }
				 echo '[
			      "'.(count($productos)).'",
			      "'.$productos[count($productos)-1]->number.'",
			      "'.$productos[count($productos)-1]->concept->name.'",
			      "'.$productos[count($productos)-1]->organization->code.'",
			      "'.$productos[count($productos)-1]->property->apartment.'",
			      "'.$productos[count($productos)-1]->date.'",
			      "'.$productos[count($productos)-1]->amount.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
}
