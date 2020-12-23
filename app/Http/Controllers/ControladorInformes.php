<?php

namespace adminph\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use adminph;

class ControladorInformes extends Controller
{
	public function controlPagos($orgId=null,$name){
		if ($orgId != null) {
			$propiedades = adminph\Property::where('organization_id',$orgId)->get();
		}else{
			$propiedades = adminph\Property::orderBy('organization_id','asc')->get();
		}
		/*===================================
			=            EXCEL CREATE            =
			===================================*/
        	setlocale(LC_TIME, 'es_ES');
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");
			$periodo = date(' M / Y ');
			echo utf8_decode("<table border='0'>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'> CONTROL</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DE PAGOS </td>
					<td></td>
					</tr>
					<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>PERIODO: </td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$periodo."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA: ".date('Y-m-d')."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>HORA: ".date('h:i:s a')."</td>
					</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>UNIDAD</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>APARTAMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PROPIETARIO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>SALDO</td>
					</tr>");
			foreach ($propiedades as $row => $propiedad){
				$propietario = $propiedad->propietary;
				$unidad = $propiedad->organization;
        		$saldo = $propiedad->first_balance + $propiedad->second_balance + $propiedad->third_balance + $propiedad->fourth_balance + $propiedad->fifth_balance + $propiedad->sixth_balance + $propiedad->seventh_balance + $propiedad->eighth_balance + $propiedad->nineth_balance + $propiedad->tenth_balance;
			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$unidad->code."</td> 
			 			<td style='border:1px solid #eee;'>".$propiedad->apartment."</td>
			 			<td style='border:1px solid #eee;'>".$propietario->name."</td>
			 			<td style='border:1px solid #eee;'>".$saldo."</td>	
		 			</tr>");
			}
			echo "</table>";
	}
	public function estadoAnaliticoDetallado($orgId=null,$name){
		if ($orgId != null) {
			$propiedades = adminph\Property::where('organization_id',$orgId)->get();
		}else{
			$propiedades = adminph\Property::orderBy('organization_id','asc')->get();
		}
		$conceptos = adminph\Concept::all();
		/*===================================
			=            EXCEL CREATE            =
			===================================*/
        	setlocale(LC_TIME, 'es_ES');
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");
			$periodo = date(' M / Y ');
			echo utf8_decode("<table border='0'>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'> ESTADO ANALÍTICO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DETALLADO </td>
					<td></td>
					</tr>
					<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>PERIODO: </td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$periodo."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA: ".date('Y-m-d')."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>HORA: ".date('h:i:s a')."</td>
					</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>UNIDAD</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>APARTAMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PROPIETARIO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CUOTA ORDINARIA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CUOTA EXTRA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>INTERES</td>
					<td style='font-weight:bold; border:1px solid #eee;'>SANCION</td>
					<td style='font-weight:bold; border:1px solid #eee;'>GASTO LEGAL</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PARQUEADERO VISITANTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NOTA DÉBITO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NOTA CRÉDITO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>ZONA COMÚN</td>
					<td style='font-weight:bold; border:1px solid #eee;'>OTROS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>SALDO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DOCUMENTO COBRO</td>
					</tr>");
			foreach ($propiedades as $row => $propiedad){

				$propietario = $propiedad->propietary;
				$factura = adminph\Bill::where('property_id',$propiedad->id)->orderBy('created_at','desc')->first();
				$unidad = $propiedad->organization;
				$bolsas = array();
        		$saldo = $propiedad->first_balance + $propiedad->second_balance + $propiedad->third_balance + $propiedad->fourth_balance + $propiedad->fifth_balance + $propiedad->sixth_balance + $propiedad->seventh_balance + $propiedad->eighth_balance + $propiedad->nineth_balance + $propiedad->tenth_balance;
				foreach ($conceptos as $key => $concepto) {
					if ($concepto->id==$unidad->first_id) {
						$bolsas[$concepto->name] = $propiedad->first_balance;
					}elseif ($concepto->id==$unidad->second_id) {
						$bolsas[$concepto->name] = $propiedad->second_balance;
					}elseif ($concepto->id==$unidad->third_id) {
						$bolsas[$concepto->name] = $propiedad->third_balance;
					}elseif ($concepto->id==$unidad->fourth_id) {
						$bolsas[$concepto->name] = $propiedad->fourth_balance;
					}elseif ($concepto->id==$unidad->fifth_id) {
						$bolsas[$concepto->name] = $propiedad->fifth_balance;
					}elseif ($concepto->id==$unidad->sixth_id) {
						$bolsas[$concepto->name] = $propiedad->sixth_balance;
					}elseif ($concepto->id==$unidad->seventh_id) {
						$bolsas[$concepto->name] = $propiedad->seventh_balance;
					}elseif ($concepto->id==$unidad->eighth_id) {
						$bolsas[$concepto->name] = $propiedad->eighth_balance;
					}elseif ($concepto->id==$unidad->nineth_id) {
						$bolsas[$concepto->name] = $propiedad->nineth_balance;
					}elseif ($concepto->id==$unidad->tenth_id) {
						$bolsas[$concepto->name] = $propiedad->tenth_balance;
					}
				}
			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$unidad->code."</td> 
			 			<td style='border:1px solid #eee;'>".$propiedad->apartment."</td>
			 			<td style='border:1px solid #eee;'>".$propietario->name."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Cuota ordinaria']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Cuota extra']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Interes']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Sancion']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Gasto legal']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Parqueadero visitante']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Nota debito']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Nota credito']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Zona comun']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Otros']."</td>
			 			<td style='border:1px solid #eee;'>".$saldo."</td>
			 			<td style='border:1px solid #eee;'>".$factura->number."</td>
		 			</tr>");
			}
			echo "</table>";
	}
	public function estadoCarteraConcepto($orgId=null,$name){
		if ($orgId != null) {
			$propiedades = adminph\Property::where('organization_id',$orgId)->get();
		}else{
			$propiedades = adminph\Property::orderBy('organization_id','asc')->get();
		}
		$conceptos = adminph\Concept::all();
		/*===================================
			=            EXCEL CREATE            =
			===================================*/
        	setlocale(LC_TIME, 'es_ES');
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");
			$periodo = date(' M / Y ');
			echo utf8_decode("<table border='0'>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'> ESTADO CARTERA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>POR CONCEPTO </td>
					<td></td>
					</tr>
					<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>PERIODO: </td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$periodo."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA: ".date('Y-m-d')."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>HORA: ".date('h:i:s a')."</td>
					</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>UNIDAD</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>APARTAMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PROPIETARIO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>SALDO ANTERIOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CUOTA ORDINARIA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CUOTA EXTRA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>INTERES</td>
					<td style='font-weight:bold; border:1px solid #eee;'>SANCION</td>
					<td style='font-weight:bold; border:1px solid #eee;'>GASTO LEGAL</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PARQUEADERO VISITANTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NOTA DÉBITO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NOTA CRÉDITO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>ZONA COMÚN</td>
					<td style='font-weight:bold; border:1px solid #eee;'>OTROS</td>
					</tr>");
			foreach ($propiedades as $row => $propiedad){

				$propietario = $propiedad->propietary;
				$factura = adminph\Bill::where('property_id',$propiedad->id)->orderBy('created_at','desc')->first();
				$unidad = $propiedad->organization;
				$bolsas = array();
				foreach ($conceptos as $key => $concepto) {
					if ($concepto->id==$unidad->first_id) {
						$bolsas[$concepto->name] = $factura->first_concept;
					}elseif ($concepto->id==$unidad->second_id) {
						$bolsas[$concepto->name] = $factura->second_concept;
					}elseif ($concepto->id==$unidad->third_id) {
						$bolsas[$concepto->name] = $factura->third_concept;
					}elseif ($concepto->id==$unidad->fourth_id) {
						$bolsas[$concepto->name] = $factura->fourth_concept;
					}elseif ($concepto->id==$unidad->fifth_id) {
						$bolsas[$concepto->name] = $factura->fifth_concept;
					}elseif ($concepto->id==$unidad->sixth_id) {
						$bolsas[$concepto->name] = $factura->sixth_concept;
					}elseif ($concepto->id==$unidad->seventh_id) {
						$bolsas[$concepto->name] = $factura->seventh_concept;
					}elseif ($concepto->id==$unidad->eighth_id) {
						$bolsas[$concepto->name] = $factura->eighth_concept;
					}elseif ($concepto->id==$unidad->nineth_id) {
						$bolsas[$concepto->name] = $factura->nineth_concept;
					}elseif ($concepto->id==$unidad->tenth_id) {
						$bolsas[$concepto->name] = $factura->tenth_concept;
					}
				}
			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$unidad->code."</td> 
			 			<td style='border:1px solid #eee;'>".$propiedad->apartment."</td>
			 			<td style='border:1px solid #eee;'>".$propietario->name."</td>
			 			<td style='border:1px solid #eee;'>".$factura->balance."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Cuota ordinaria']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Cuota extra']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Interes']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Sancion']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Gasto legal']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Parqueadero visitante']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Nota debito']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Nota credito']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Zona comun']."</td>
			 			<td style='border:1px solid #eee;'>".$bolsas['Otros']."</td>
		 			</tr>");
			}
			echo "</table>";
	}
	public function estadoCuenta($orgId=null,$name,$firstDate=null,$lastDate=null){
		if ($orgId != null) {
			$propiedades = adminph\Property::where('organization_id',$orgId)->get();
		}else{
			$propiedades = adminph\Property::orderBy('organization_id','asc')->get();
		}
		$conceptos = adminph\Concept::all();
		/*===================================
			=            EXCEL CREATE            =
			===================================*/
        	setlocale(LC_TIME, 'es_ES');
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");
			echo utf8_decode("<table border='0'>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'> ESTADO </td>
					<td style='font-weight:bold; border:1px solid #eee;'>DE CUENTA </td>
					<td></td>
					</tr>
					<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>DESDE: ".date($firstDate)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>HASTA: ".date($firstDate)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA: ".date('Y-m-d')."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>HORA: ".date('h:i:s a')."</td>
					</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>");
			foreach ($propiedades as $row => $propiedad){

				if ($firstDate != null && $firstDate != "" && $lastDate != null && $lastDate != "") {
					$facturas = adminph\Bill::where('property_id',$propiedad->id)->whereBetween('created_at', [$firstDate, $lastDate])->orderBy('created_at','asc')->get();
				}else{
					$facturas = adminph\Bill::where('property_id',$propiedad->id)->orderBy('created_at','asc')->get();
				}
				$propietario = $propiedad->propietary;
				$unidad = $propiedad->organization;
				$descuento = adminph\Concept::where('name','Descuento')->first();
				$totales = array();
				foreach ($conceptos as $key => $concepto) {
					$totales[$concepto->name] = 0;
				}
				$totales['Pago'] = 0;
				echo utf8_decode("<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>UNIDAD: </td>
					<td style='font-weight:bold; border:1px solid #eee;'> ".$unidad->name."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>APARTAMENTO: </td>
					<td style='font-weight:bold; border:1px solid #eee;'> ".$propiedad->apartment."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PROPIETARIO: </td>
					<td style='font-weight:bold; border:1px solid #eee;'> ".$propietario->name."</td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>PERIODO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>SALDO INICIAL</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CUOTA ORDINARIA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CUOTA EXTRA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>INTERES</td>
					<td style='font-weight:bold; border:1px solid #eee;'>SANCION</td>
					<td style='font-weight:bold; border:1px solid #eee;'>GASTO LEGAL</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PARQUEADERO VISITANTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NOTA DÉBITO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NOTA CRÉDITO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>ZONA COMÚN</td>
					<td style='font-weight:bold; border:1px solid #eee;'>OTROS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DESCUENTOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PAGOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>SALDO</td>
					</tr>");
				foreach ($facturas as $factura) {
     				date_default_timezone_set('America/Bogota');
				   	$month = $factura->created_at->format('m');
				   	$year = $factura->created_at->format('Y');
      				setlocale(LC_TIME, 'es_ES');
				   	$periodo = $factura->created_at->format(' M / Y');
					$pagos = adminph\Payment::where('property_id',$propiedad->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->get();
					$descuentoDoc = adminph\Document::where('concept_id',$descuento->id)->where('property_id',$propiedad->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->first();
					$pagoTot = 0;
					if ($pagos != null && $pagos != "") {
						foreach ($pagos as $key => $pago) {
							$pagoTot += $pago->amount;
						}
					}
					$totales['Descuento']+=$descuentoDoc->amount;
					$totales['Pago']+=$pagoTot;
					$bolsas = array();
					foreach ($conceptos as $key => $concepto) {
						if ($concepto->id==$unidad->first_id) {
							$bolsas[$concepto->name] = $factura->first_concept;
							$totales[$concepto->name] += $factura->first_concept;
						}elseif ($concepto->id==$unidad->second_id) {
							$bolsas[$concepto->name] = $factura->second_concept;
							$totales[$concepto->name] += $factura->second_concept;
						}elseif ($concepto->id==$unidad->third_id) {
							$bolsas[$concepto->name] = $factura->third_concept;
							$totales[$concepto->name] += $factura->third_concept;
						}elseif ($concepto->id==$unidad->fourth_id) {
							$bolsas[$concepto->name] = $factura->fourth_concept;
							$totales[$concepto->name] += $factura->fourth_concept;
						}elseif ($concepto->id==$unidad->fifth_id) {
							$bolsas[$concepto->name] = $factura->fifth_concept;
							$totales[$concepto->name] += $factura->fifth_concept;
						}elseif ($concepto->id==$unidad->sixth_id) {
							$bolsas[$concepto->name] = $factura->sixth_concept;
							$totales[$concepto->name] += $factura->sixth_concept;
						}elseif ($concepto->id==$unidad->seventh_id) {
							$bolsas[$concepto->name] = $factura->seventh_concept;
							$totales[$concepto->name] += $factura->seventh_concept;
						}elseif ($concepto->id==$unidad->eighth_id) {
							$bolsas[$concepto->name] = $factura->eighth_concept;
							$totales[$concepto->name] += $factura->eighth_concept;
						}elseif ($concepto->id==$unidad->nineth_id) {
							$bolsas[$concepto->name] = $factura->nineth_concept;
							$totales[$concepto->name] += $factura->nineth_concept;
						}elseif ($concepto->id==$unidad->tenth_id) {
							$bolsas[$concepto->name] = $factura->tenth_concept;
							$totales[$concepto->name] += $factura->tenth_concept;
						}
					}
					$saldo = $factura->total - $descuentoDoc->amount - $pagoTot;
			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$periodo."</td>
			 			<td style='border:1px solid #eee;'>$ ".number_format($factura->balance,2)."</td>
			 			<td style='border:1px solid #eee;'>$ ".number_format($bolsas['Cuota ordinaria'],2)."</td>
			 			<td style='border:1px solid #eee;'>$ ".number_format($bolsas['Cuota extra'],2)."</td>
			 			<td style='border:1px solid #eee;'>$ ".number_format($bolsas['Interes'],2)."</td>
			 			<td style='border:1px solid #eee;'>$ ".number_format($bolsas['Sancion'],2)."</td>
			 			<td style='border:1px solid #eee;'>$ ".number_format($bolsas['Gasto legal'],2)."</td>
			 			<td style='border:1px solid #eee;'>$ ".number_format($bolsas['Parqueadero visitante'],2)."</td>
			 			<td style='border:1px solid #eee;'>$ ".number_format($bolsas['Nota debito'],2)."</td>
			 			<td style='border:1px solid #eee;'>$ ".number_format($bolsas['Nota credito'],2)."</td>
			 			<td style='border:1px solid #eee;'>$ ".number_format($bolsas['Zona comun'],2)."</td>
			 			<td style='border:1px solid #eee;'>$ ".number_format($bolsas['Otros'],2)."</td>
			 			<td style='border:1px solid #eee;'>$ ".number_format($descuentoDoc->amount,2)."</td>
			 			<td style='border:1px solid #eee;'>$ ".number_format($pagoTot,2)."</td>
			 			<td style='border:1px solid #eee;'>$ ".number_format($saldo,2)."</td>
		 			</tr>");
				}
			 echo utf8_decode("<tr>
			 			<td style='border-top:1px solid #eee;'> TOTAL </td>
			 			<td style='border-top:1px solid #eee;'></td>
			 			<td style='border-top:1px solid #eee;'>$ ".number_format($totales['Cuota ordinaria'],2)."</td>
			 			<td style='border-top:1px solid #eee;'>$ ".number_format($totales['Cuota extra'],2)."</td>
			 			<td style='border-top:1px solid #eee;'>$ ".number_format($totales['Interes'],2)."</td>
			 			<td style='border-top:1px solid #eee;'>$ ".number_format($totales['Sancion'],2)."</td>
			 			<td style='border-top:1px solid #eee;'>$ ".number_format($totales['Gasto legal'],2)."</td>
			 			<td style='border-top:1px solid #eee;'>$ ".number_format($totales['Parqueadero visitante'],2)."</td>
			 			<td style='border-top:1px solid #eee;'>$ ".number_format($totales['Nota debito'],2)."</td>
			 			<td style='border-top:1px solid #eee;'>$ ".number_format($totales['Nota credito'],2)."</td>
			 			<td style='border-top:1px solid #eee;'>$ ".number_format($totales['Zona comun'],2)."</td>
			 			<td style='border-top:1px solid #eee;'>$ ".number_format($totales['Otros'],2)."</td>
			 			<td style='border-top:1px solid #eee;'>$ ".number_format($totales['Descuento'],2)."</td>
			 			<td style='border-top:1px solid #eee;'>$ ".number_format($totales['Pago'],2)."</td>
			 			<td style='border-top:1px solid #eee;'></td>
		 			</tr>
		 			<tr>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			</tr>");
			}
			echo "</table>";
	}
	public function movimientoCartera($orgId=null,$name,$firstDate=null,$lastDate=null){
		if ($orgId != null) {
			$propiedades = adminph\Property::where('organization_id',$orgId)->get();
		}else{
			$propiedades = adminph\Property::orderBy('organization_id','asc')->get();
		}
		/*===================================
			=            EXCEL CREATE            =
			===================================*/
        	setlocale(LC_TIME, 'es_ES');
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");
			echo utf8_decode("<table border='0'>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'> ESTADO </td>
					<td style='font-weight:bold; border:1px solid #eee;'>DE CUENTA </td>
					<td></td>
					</tr>
					<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>DESDE: ".date($firstDate)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>HASTA: ".date($firstDate)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA: ".date('Y-m-d')."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>HORA: ".date('h:i:s a')."</td>
					</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>");
			foreach ($propiedades as $row => $propiedad){

				if ($firstDate != null && $firstDate != "" && $lastDate != null && $lastDate != "") {
					$facturas = adminph\Bill::where('property_id',$propiedad->id)->whereBetween('created_at', [$firstDate, $lastDate])->orderBy('created_at','asc')->get();
				}else{
					$facturas = adminph\Bill::where('property_id',$propiedad->id)->orderBy('created_at','asc')->get();
				}
				$propietario = $propiedad->propietary;
				$unidad = $propiedad->organization;
				$saldo = 0;
				echo utf8_decode("<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>UNIDAD: </td>
					<td style='font-weight:bold; border:1px solid #eee;'> ".$unidad->name."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>APARTAMENTO: </td>
					<td style='font-weight:bold; border:1px solid #eee;'> ".$propiedad->apartment."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PROPIETARIO: </td>
					<td style='font-weight:bold; border:1px solid #eee;'> ".$propietario->name."</td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>PERIODO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CONCEPTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DOCUMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VALOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>SALDO</td>
					</tr>");
				foreach ($facturas as $factura) {
     				date_default_timezone_set('America/Bogota');
				   	$month = $factura->created_at->format('m');
				   	$year = $factura->created_at->format('Y');
      				setlocale(LC_TIME, 'es_ES');
					$documentos = adminph\Document::where('property_id',$propiedad->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->get();
					$pagos = adminph\Payment::where('property_id',$propiedad->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->get();
					$pagoTot = 0;
					if ($pagos != null && $pagos != "") {
						foreach ($pagos as $key => $pago) {
							$pagoTot += $pago->amount;
						}
					}
					foreach ($documentos as $documento) {
						switch ($documento->concept->name) {
							case 'Descuento':
								$saldo -= $documento->amount;
								break;
							case 'Nota credito':
								$saldo -= $documento->amount;
								break;
							default:
								$saldo += $documento->amount;
								break;
						}
				   		$periodo = $documento->created_at->format(' M / Y');
			 			echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$periodo."</td>
						<td style='font-weight:bold; border:1px solid #eee;'>".$documento->concept->name."</td>
						<td style='font-weight:bold; border:1px solid #eee;'>".$documento->number."</td>
						<td style='font-weight:bold; border:1px solid #eee;'>".$documento->created_at->format('d-m-Y')."</td>
						<td style='font-weight:bold; border:1px solid #eee;'>".$documento->amount."</td>
						<td style='font-weight:bold; border:1px solid #eee;'>".$saldo."</td>
		 			</tr>");
					}
			   		$periodo = $pagos[0]->created_at->format(' M / Y');
					$saldo -= $pagoTot;
		 			echo utf8_decode("<tr>
		 			<td style='border:1px solid #eee;'>".$periodo."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>Pagos aplicados</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$pagos[0]->ref_document."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$pagos[0]->payment_date->format('d-m-Y')."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$pagoTot."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$saldo."</td>
	 				</tr>");

				}
			 echo utf8_decode("<tr>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			<td></td>
		 			</tr>");
			}
			echo "</table>";
	}
	public function informeFacturacionAnalitico($orgId=null,$name,$firstDate=null,$lastDate=null){
		if ($orgId != null && $firstDate != null && $firstDate != "" && $lastDate != null && $lastDate != "") {
			$facturas = adminph\Bill::where('organization_id',$orgId)->whereBetween('created_at', [$firstDate, $lastDate])->get();
		}elseif ($orgId != null) {
			$facturas = adminph\Bill::where('organization_id',$orgId)->get();
		}else{
			$facturas = adminph\Bill::orderBy('organization_id','asc')->get();
		}
		$conceptos = adminph\Concept::all();
		/*===================================
			=            EXCEL CREATE            =
			===================================*/
        	setlocale(LC_TIME, 'es_ES');
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");
			if ($lastDate != null && $lastDate != "") {
				$periodo = Carbon::parse($lastDate)->format(' M / Y ');
			}else{
				$periodo = date(' M / Y ');
			}
			echo utf8_decode("<table border='0'>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'> INFORME DE FACTURACIÓN</td>
					<td style='font-weight:bold; border:1px solid #eee;'>ANALÍTICO DEL MES </td>
					<td></td>
					</tr>
					<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>PERIODO: </td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$periodo."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA: ".date('Y-m-d')."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>HORA: ".date('h:i:s a')."</td>
					</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>UNIDAD</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>APARTAMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PROPIETARIO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DOCUMENTO COBRO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PAGO MES ANTERIOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CUOTA ORDINARIA ANTERIOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CUOTA EXTRA ANTERIOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>INTERES ANTERIOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>SANCION ANTERIOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>GASTO LEGAL ANTERIOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PARQUEADERO VISITANTE ANTERIOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NOTA DÉBITO ANTERIOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NOTA CRÉDITO ANTERIOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>ZONA COMÚN ANTERIOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>OTROS ANTERIOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CUOTA ORDINARIA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CUOTA EXTRA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>INTERES</td>
					<td style='font-weight:bold; border:1px solid #eee;'>SANCION</td>
					<td style='font-weight:bold; border:1px solid #eee;'>GASTO LEGAL</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PARQUEADERO VISITANTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NOTA DÉBITO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NOTA CRÉDITO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>ZONA COMÚN</td>
					<td style='font-weight:bold; border:1px solid #eee;'>OTROS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>SALDO ACTUAL</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DESCUENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>SALDO CON DESCUENTO</td>
					</tr>");
			foreach ($facturas as $row => $factura){
				$propiedad = $factura->property;
				$propietario = $propiedad->propietary;
				$unidad = $propiedad->organization;
				$fecha = Carbon::parse($factura->created_at)->subMonth();
				$month = $fecha->format('m');
				$year = $fecha->format('Y');
				$bolsas = array();
				$bolsas2 = array();
				$pagos = adminph\Payment::where('property_id',$propiedad->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->get();
				$pagoTot = 0;
				if ($pagos != null && $pagos != "") {
					foreach ($pagos as $key => $pago) {
						$pagoTot += $pago->amount;
					}
				}
				$saldoDesc = $factura->total-$factura->discount;
				foreach ($conceptos as $key => $concepto) {
					if ($concepto->id==$unidad->first_id) {
						$bolsas[$concepto->name] = $factura->first_balance;
						$bolsas2[$concepto->name] = $factura->first_concept;
					}elseif ($concepto->id==$unidad->second_id) {
						$bolsas[$concepto->name] = $factura->second_balance;
						$bolsas2[$concepto->name] = $factura->second_concept;
					}elseif ($concepto->id==$unidad->third_id) {
						$bolsas[$concepto->name] = $factura->third_balance;
						$bolsas2[$concepto->name] = $factura->third_concept;
					}elseif ($concepto->id==$unidad->fourth_id) {
						$bolsas[$concepto->name] = $factura->fourth_balance;
						$bolsas2[$concepto->name] = $factura->fourth_concept;
					}elseif ($concepto->id==$unidad->fifth_id) {
						$bolsas[$concepto->name] = $factura->fifth_balance;
						$bolsas2[$concepto->name] = $factura->fifth_concept;
					}elseif ($concepto->id==$unidad->sixth_id) {
						$bolsas[$concepto->name] = $factura->sixth_balance;
						$bolsas2[$concepto->name] = $factura->sixth_concept;
					}elseif ($concepto->id==$unidad->seventh_id) {
						$bolsas[$concepto->name] = $factura->seventh_balance;
						$bolsas2[$concepto->name] = $factura->seventh_concept;
					}elseif ($concepto->id==$unidad->eighth_id) {
						$bolsas[$concepto->name] = $factura->eighth_balance;
						$bolsas2[$concepto->name] = $factura->eighth_concept;
					}elseif ($concepto->id==$unidad->nineth_id) {
						$bolsas[$concepto->name] = $factura->nineth_balance;
						$bolsas2[$concepto->name] = $factura->nineth_concept;
					}elseif ($concepto->id==$unidad->tenth_id) {
						$bolsas[$concepto->name] = $factura->tenth_balance;
						$bolsas2[$concepto->name] = $factura->tenth_concept;
					}
				}
			 echo utf8_decode("<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>".$unidad->code."</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>".$propiedad->apartament."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$propietario->name."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$factura->number."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$pagoTot."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas['Cuota ordinaria']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas['Cuota extra']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas['Interes']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas['Sancion']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas['Gasto legal']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas['Parqueadero visitante']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas['Nota debito']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas['Nota credito']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas['Zona comun']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas['Otros']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas2['Cuota ordinaria']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas2['Cuota extra']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas2['Interes']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas2['Sancion']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas2['Gasto legal']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas2['Parqueadero visitante']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas2['Nota debito']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas2['Nota credito']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas2['Zona comun']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$bolsas2['Otros']."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$factura->total."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$factura->discount."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$factura->number."</td>
					</tr>");
			}
			echo "</table>";
	}
	public function listadoCopropiedades($orgId=null,$name){
		if ($orgId != null) {
			$propiedades = adminph\Property::where('organization_id',$orgId)->get();
		}else{
			$propiedades = adminph\Property::orderBy('organization_id','asc')->get();
		}
		$conceptos = adminph\Concept::all();
		/*===================================
			=            EXCEL CREATE            =
			===================================*/
        	setlocale(LC_TIME, 'es_ES');
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");
			echo utf8_decode("<table border='0'>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'> LISTADO DE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>COPROPIEDADES </td>
					<td></td>
					</tr>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA: ".date('Y-m-d')."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>HORA: ".date('h:i:s a')."</td>
					<td></td>
					</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>UNIDAD</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>APARTAMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PROPIETARIO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>COEFICIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PARQUEADERO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>COEFICIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CUARTO ÚTIL</td>
					<td style='font-weight:bold; border:1px solid #eee;'>COEFICIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>COEFICIENTE TOTAL</td>
					<td style='font-weight:bold; border:1px solid #eee;'>TELEFONO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DIRECCIÓN</td>
					</tr>");
			foreach ($propiedades as $row => $propiedad){

				$propietario = $propiedad->propietary;
				$unidad = $propiedad->organization;
				$coef = $propiedad->apartment_coefficient + $propiedad->parking_coefficient + $propiedad->useful_room_coefficient;
			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$unidad->code."</td> 
			 			<td style='border:1px solid #eee;'>".$propiedad->apartment."</td>
			 			<td style='border:1px solid #eee;'>".$propietario->name."</td>
			 			<td style='border:1px solid #eee;'>".$propiedad->apartment_coefficient."</td>
			 			<td style='border:1px solid #eee;'>".$propiedad->parking."</td>
			 			<td style='border:1px solid #eee;'>".$propiedad->parking_coefficient."</td>
			 			<td style='border:1px solid #eee;'>".$propiedad->useful_room."</td>
			 			<td style='border:1px solid #eee;'>".$propiedad->useful_room_coefficient."</td>
			 			<td style='border:1px solid #eee;'>".$coef."</td>
			 			<td style='border:1px solid #eee;'>".$propietario->phone1."-".$propietario->phone2."</td>
			 			<td style='border:1px solid #eee;'>".$propietario->address."</td>
		 			</tr>");
			}
			echo "</table>";
	}
	public function listadoNotasCredito($orgId=null,$name,$firstDate=null,$lastDate=null){ 
		$notaCredito = adminph\Concept::where('name','Nota credito')->first();
		if ($orgId != null && $firstDate != null && $firstDate != "" && $lastDate != null && $lastDate != "") {
			$documentos = adminph\Property::where('organization_id',$orgId)->where('concept_id',$notaCredito->id)->whereBetween('created_at', [$firstDate, $lastDate])->get();
		}elseif ($orgId != null) {
			$documentos = adminph\Property::where('organization_id',$orgId)->where('concept_id',$notaCredito->id)->get();
		}else{
			$documentos = adminph\Property::orderBy('organization_id','asc')->where('concept_id',$notaCredito->id)->get();
		}
		/*===================================
			=            EXCEL CREATE            =
			===================================*/
        	setlocale(LC_TIME, 'es_ES');
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");
			echo utf8_decode("<table border='0'>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'> LISTADO DE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NOTAS CREDITO </td>
					<td></td>
					</tr>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA: ".date('Y-m-d')."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>HORA: ".date('h:i:s a')."</td>
					<td></td>
					</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>UNIDAD</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>APARTAMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PROPIETARIO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CONCEPTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DOCUMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VALOR</td>					
					</tr>");
			foreach ($documentos as $row => $documento){
				$propiedad = $documento->property;
				$propietario = $propiedad->propietary;
				$unidad = $propiedad->organization;
			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$unidad->code."</td> 
			 			<td style='border:1px solid #eee;'>".$propiedad->apartment."</td>
			 			<td style='border:1px solid #eee;'>".$propietario->name."</td>
			 			<td style='border:1px solid #eee;'>".$documento->body."</td>
			 			<td style='border:1px solid #eee;'>".$documento->number."</td>
			 			<td style='border:1px solid #eee;'>".$documento->date."</td>
			 			<td style='border:1px solid #eee;'>".$documento->amount."</td>
		 			</tr>");
			}
			echo "</table>";
	}
	public function listadoNotasDebito($orgId=null,$name,$firstDate=null,$lastDate=null){ 
		$notaDebito = adminph\Concept::where('name','Nota debito')->first();
		if ($orgId != null && $firstDate != null && $firstDate != "" && $lastDate != null && $lastDate != "") {
			$documentos = adminph\Property::where('organization_id',$orgId)->where('concept_id',$notaDebito->id)->whereBetween('created_at', [$firstDate, $lastDate])->get();
		}elseif ($orgId != null) {
			$documentos = adminph\Property::where('organization_id',$orgId)->where('concept_id',$notaDebito->id)->get();
		}else{
			$documentos = adminph\Property::orderBy('organization_id','asc')->where('concept_id',$notaDebito->id)->get();
		}
		/*===================================
			=            EXCEL CREATE            =
			===================================*/
        	setlocale(LC_TIME, 'es_ES');
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");
			echo utf8_decode("<table border='0'>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'> LISTADO DE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NOTAS DEBITO </td>
					<td></td>
					</tr>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA: ".date('Y-m-d')."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>HORA: ".date('h:i:s a')."</td>
					<td></td>
					</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>UNIDAD</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>APARTAMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PROPIETARIO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CONCEPTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DOCUMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VALOR</td>					
					</tr>");
			foreach ($documentos as $row => $documento){
				$propiedad = $documento->property;
				$propietario = $propiedad->propietary;
				$unidad = $propiedad->organization;
			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$unidad->code."</td> 
			 			<td style='border:1px solid #eee;'>".$propiedad->apartment."</td>
			 			<td style='border:1px solid #eee;'>".$propietario->name."</td>
			 			<td style='border:1px solid #eee;'>".$documento->body."</td>
			 			<td style='border:1px solid #eee;'>".$documento->number."</td>
			 			<td style='border:1px solid #eee;'>".$documento->date."</td>
			 			<td style='border:1px solid #eee;'>".$documento->amount."</td>
		 			</tr>");
			}
			echo "</table>";
	}
	public function listadoPagos($orgId=null,$name,$firstDate=null,$lastDate=null){ 
		$fecha1 = "";
		$fecha2 = "";
		if ($orgId != null && $firstDate != null && $firstDate != "" && $lastDate != null && $lastDate != "") {
			$pagos = adminph\Payment::where('organization_id',$orgId)->whereBetween('created_at', [$firstDate, $lastDate])->get();
			$fecha1 = $firstDate;
			$fecha2 = $lastDate;
		}elseif ($orgId != null) {
			$pagos = adminph\Payment::where('organization_id',$orgId)->get();
		}else{
			$pagos = adminph\Payment::orderBy('organization_id','asc')->get();
		}
		/*===================================
			=            EXCEL CREATE            =
			===================================*/
        	setlocale(LC_TIME, 'es_ES');
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");
			echo utf8_decode("<table border='0'>
					<tr>
					<td style='font-weight:bold; border:1px solid #eee;'> PAGOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DEL PERIODO </td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$fecha1." - </td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$fecha2."</td>
					</tr>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA: ".date('Y-m-d')."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>HORA: ".date('h:i:s a')."</td>
					<td></td>
					</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>UNIDAD</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>APARTAMENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PROPIETARIO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>RECIBO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VALOR</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>DOCUMENTO REFERENCIA</td>			
					</tr>");
			foreach ($pagos as $row => $pago){
				$propiedad = $pago->property;
				$propietario = $propiedad->propietary;
				$unidad = $propiedad->organization;
			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$unidad->code."</td> 
			 			<td style='border:1px solid #eee;'>".$propiedad->apartment."</td>
			 			<td style='border:1px solid #eee;'>".$propietario->name."</td>
			 			<td style='border:1px solid #eee;'>".$pago->number."</td>
			 			<td style='border:1px solid #eee;'>".$pago->payment_date."</td>
			 			<td style='border:1px solid #eee;'>".$pago->amount."</td>
			 			<td style='border:1px solid #eee;'>".$pago->ref_document."</td>
		 			</tr>");
			}
			echo "</table>";
	}
	public function informeFacturacion($orgId=null,$name,$firstDate=null,$lastDate=null){
		if ($orgId != null) {
			$propiedades = adminph\Property::where('organization_id',$orgId)->get();
		}else{
			$propiedades = adminph\Property::orderBy('organization_id','asc')->get();
		}
		$conceptos = adminph\Concept::all();
		/*===================================
			=            EXCEL CREATE            =
			===================================*/
        	setlocale(LC_TIME, 'es_ES');
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");
			if ($lastDate != null && $lastDate != "") {
				$periodo = Carbon::parse($lastDate)->format(' M / Y ');
			}else{
				$periodo = date(' M / Y ');
			}
			echo utf8_decode("<table border='0'>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'> INFORME DE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FACTURACIÓN </td>
					<td></td>
					</tr>
					<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>PERIODO: </td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$periodo."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA: ".date('Y-m-d')."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>HORA: ".date('h:i:s a')."</td>
					</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>");
			foreach ($propiedades as $row => $propiedad){
				$propietario = $propiedad->propietary;
				$unidad = $propiedad->organization;
				$facturas = adminph\Bill::where('property_id',$propiedad->id)->whereBetween('created_at', [$firstDate, $lastDate])->orderBy('created_at','desc')->get();	
				$conceptos = adminph\Concept::all();		
				$conceptosUnidad = array();
				foreach ($conceptos as $concepto) {
				 	if ($concepto->id == $unidad->first_id) {
				 		$conceptosUnidad['first']=$concepto->name;
				 	}elseif ($concepto->id == $unidad->second_id) {
				 		$conceptosUnidad['second']=$concepto->name;
				 	}elseif ($concepto->id == $unidad->third_id) {
				 		$conceptosUnidad['third']=$concepto->name;
				 	}elseif ($concepto->id == $unidad->fourth_id) {
				 		$conceptosUnidad['fourth']=$concepto->name;
				 	}elseif ($concepto->id == $unidad->fifth_id) {
				 		$conceptosUnidad['fifth']=$concepto->name;
				 	}elseif ($concepto->id == $unidad->sixth_id) {
				 		$conceptosUnidad['sixth']=$concepto->name;
				 	}elseif ($concepto->id == $unidad->seventh_id) {
				 		$conceptosUnidad['seventh']=$concepto->name;
				 	}elseif ($concepto->id == $unidad->eighth_id) {
				 		$conceptosUnidad['eighth']=$concepto->name;
				 	}elseif ($concepto->id == $unidad->nineth_id) {
				 		$conceptosUnidad['nineth']=$concepto->name;
				 	}elseif ($concepto->id == $unidad->tenth_id) {
				 		$conceptosUnidad['tenth']=$concepto->name;
				 	}
				 } 
				echo utf8_decode("
					<tr>
			 			<td style='border:1px solid #eee;'>".$unidad->code."</td> 
			 			<td style='border:1px solid #eee;'>".$propiedad->apartment."</td>
			 			<td style='border:1px solid #eee;'>".$propietario->name."</td>
			 			<td style='border:1px solid #eee;'>Facturas: </td>");
				if (is_object($facturas)) {
					foreach ($facturas as $factura) {
						echo utf8_decode("
			 			<td style='border:1px solid #eee;'>".$factura->number."</td>");
					}
				}
				echo utf8_decode("
		 			</tr>");
				if (is_object($facturas)) {
					foreach ($facturas as $factura) {
						echo utf8_decode("<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CONCEPTO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>SALDO ANTERIOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>ESTE MES</td>
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>".$conceptosUnidad['first']."</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->first_balance,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->first_concept,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->first_balance + $factura->first_concept,2)."</td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>".$conceptosUnidad['second']."</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->second_balance,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->second_concept,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->second_balance + $factura->second_concept,2)."</td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>".$conceptosUnidad['third']."</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->third_balance,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->third_concept,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->third_balance + $factura->third_concept,2)."</td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>".$conceptosUnidad['fourth']."</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->fourth_balance,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->fourth_concept,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->fourth_balance + $factura->fourth_concept,2)."</td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>".$conceptosUnidad['fifth']."</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->fifth_balance,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->fifth_concept,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->fifth_balance + $factura->fifth_concept,2)."</td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>".$conceptosUnidad['sixth']."</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->sixth_balance,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->sixth_concept,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->sixth_balance + $factura->sixth_concept,2)."</td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>".$conceptosUnidad['seventh']."</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->seventh_balance,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->seventh_concept,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->seventh_balance + $factura->seventh_concept,2)."</td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>".$conceptosUnidad['eighth']."</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->eighth_balance,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->eighth_concept,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->eighth_balance + $factura->eighth_concept,2)."</td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>".$conceptosUnidad['nineth']."</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->nineth_balance,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->nineth_concept,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->nineth_balance + $factura->nineth_concept,2)."</td>
					</tr>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>".$conceptosUnidad['tenth']."</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->tenth_balance,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->tenth_concept,2)."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->tenth_balance + $factura->tenth_concept,2)."</td>
					</tr>");
					$fecha = Carbon::parse($factura->created_at)->subMonth();
					$month = $fecha->format('m');
					$year = $fecha->format('Y');
					$pagos = adminph\Payment::where('property_id',$propiedad->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->get();
					$pagoTot = 0;
					if ($pagos != null && $pagos != "") {
						foreach ($pagos as $key => $pago) {
							$pagoTot += $pago->amount;
						}
					}
					echo utf8_decode("<tr>
					<td style='font-weight:bold; border:1px solid #eee;'><b>PAGO ANTERIOR: </b></td> 
					<td style='font-weight:bold; border:1px solid #eee;'>$ <b>".number_format($pagoTot,2)."</b></td>
					<td style='font-weight:bold; border:1px solid #eee;'><b>TOTAL A PAGAR: </b></td>
					<td style='font-weight:bold; border:1px solid #eee;'>$ ".number_format($factura->total,2)."</td>
						</tr>");
					}
				}
			}
			echo "</table>";
	}
	public function vencimientoCartera($orgId=null,$name){ 
		if ($orgId != null) {
			$propiedades = adminph\Property::where('organization_id',$orgId)->get();
		}else{
			$propiedades = adminph\Property::orderBy('organization_id','asc')->get();
		}
		$periodo = date(' M / Y ');
		$conceptos = adminph\Concept::all();

		/*===================================
			=            EXCEL CREATE            =
			===================================*/
        	setlocale(LC_TIME, 'es_ES');
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");
			date_default_timezone_set('America/Bogota');
			echo utf8_decode("<table border='0'>
					<tr>
					<td style='font-weight:bold; border:1px solid #eee;'> VENCIMIENTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DE CARTERA </td>
					<td style='font-weight:bold; border:1px solid #eee;'>PERIODO: </td>
					<td style='font-weight:bold; border:1px solid #eee;'>".$periodo."</td>
					</tr>
					<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA: ".date('Y-m-d')."</td>
					<td style='font-weight:bold; border:1px solid #eee;'>HORA: ".date('h:i:s a')."</td>
					<td></td>
					</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>");
			foreach ($propiedades as $row => $propiedad){
				$propietario = $propiedad->propietary;
				$unidad = $propiedad->organization;
			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$unidad->code."</td> 
			 			<td style='border:1px solid #eee;'>".$propiedad->apartment."</td>
			 			<td style='border:1px solid #eee;'>".$propietario->name."</td>
		 			</tr>
		 			<tr>
					<td style='font-weight:bold; border:1px solid #eee;'>CONCEPTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>SALDO TOTAL</td>
					<td style='font-weight:bold; border:1px solid #eee;'>1 a 30 DIAS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>31 a 60 DIAS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>61 a 90 DIAS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>MÁS DE 90 DIAS</td>
		 			</tr>");
			 foreach ($conceptos as $concepto) {
			 	if ($concepto->name != "Descuento" && $concepto->name != "Nota credito") {
			 		$notas = adminph\Note::where('concept_id',$concepto->id)->where('property_id',$propiedad->id)->get();
			 		$saldoTot = 0;
			 		$saldo1 = 0;
			 		$saldo2 = 0;
			 		$saldo3 = 0;
			 		$saldo4 = 0;
			 		foreach ($notas as $nota) {
						$now = new DateTime('now');
						$date = new DateTime($nota->created_at);
						$interval = $now->diff($date);
						$dif = (int)$interval->format('%a');
						if ($dif<31) {
							$saldoTot += $nota->amount;
							$saldo1 += $nota->amount;
						}elseif ($dif>30 && $dif<61) {
							$saldoTot += $nota->amount;
							$saldo2 += $nota->amount;
						}elseif ($dif>60 && $dif<91) {
							$saldoTot += $nota->amount;
							$saldo3 += $nota->amount;
						}else{
							$saldoTot += $nota->amount;
							$saldo4 += $nota->amount;
						}
			 		}
				 echo utf8_decode("<tr>
						<td style='font-weight:bold; border:1px solid #eee;'>".$concepto->name."</td>
						<td style='font-weight:bold; border:1px solid #eee;'>".$saldoTot."</td>
						<td style='font-weight:bold; border:1px solid #eee;'>".$saldo1."</td>
						<td style='font-weight:bold; border:1px solid #eee;'>".$saldo2."</td>
						<td style='font-weight:bold; border:1px solid #eee;'>".$saldo3."</td>
						<td style='font-weight:bold; border:1px solid #eee;'>".$saldo4."</td>
			 			</tr>");
			 	}
			 }
			}
			echo "</table>";
	}
}