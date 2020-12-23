<?php

namespace adminph\Http\Controllers;
use adminph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use PDF;
use App;
use Mpdf;

use Carbon\Carbon;

class ControladorGeneral extends Controller
{
  
    public function vistaHome(Request $request){
      if ($request->session()->get('rank')=="Admin") {
          $usuarios = adminph\User::all();
          $unidades = adminph\Organization::all();
          return view('layouts.users',['usuarios'=>$usuarios,'unidades'=>$unidades]);
      }elseif ($request->session()->get('rank')=='Concejo') {
          $areaMonths = array();
          $areaBills = array();
          $areaPays = array();
          $areaExpenses = array();
          $barMonths = array();
          $barBills = array();
          $barPays = array();
          $barExpenses = array();
          $now = Carbon::now();
          $year = $now->format('Y');
          $firstMD = $hoy->startOfMonth();
          $lastMD = $hoy->endOfMonth();
          $lastMD = $lastMD->addDay();
          $billed = DB::table('bills')->whereBetween('created_at', [$firstMD, $lastMD])->sum('total');
          $paid = DB::table('payments')->whereBetween('payment_date', [$firstMD, $lastMD])->sum('amount');
          $used = DB::table('expenses')->whereBetween('date', [$firstMD, $lastMD])->sum('amount');
            array_push($areaMonths, 'Enero');
            $billedTemp = DB::table('bills')->whereBetween('created_at', [Carbon::parse($year.'-01-01'), Carbon::parse($year.'-02-01')])->sum('total');
            $paidTemp = DB::table('payments')->whereBetween('payment_date', [Carbon::parse($year.'-01-01'), Carbon::parse($year.'-02-01')])->sum('amount');
            $usedTemp = DB::table('expenses')->whereBetween('date', [Carbon::parse($year.'-01-01'), Carbon::parse($year.'-02-01')])->sum('amount');
            array_push($areaBills, $billedTemp);
            array_push($areaPays, $paidTemp);
            array_push($areaExpenses, $usedTemp);
            array_push($areaMonths, 'Febrero');
            $billedTemp = DB::table('bills')->whereBetween('created_at', [Carbon::parse($year.'-02-01'), Carbon::parse($year.'-03-01')])->sum('total');
            $paidTemp = DB::table('payments')->whereBetween('payment_date', [Carbon::parse($year.'-02-01'), Carbon::parse($year.'-03-01')])->sum('amount');
            $usedTemp = DB::table('expenses')->whereBetween('date', [Carbon::parse($year.'-02-01'), Carbon::parse($year.'-03-01')])->sum('amount');
            array_push($areaBills, $billedTemp);
            array_push($areaPays, $paidTemp);
            array_push($areaExpenses, $usedTemp);
            array_push($areaMonths, 'Marzo');
            $billedTemp = DB::table('bills')->whereBetween('created_at', [Carbon::parse($year.'-03-01'), Carbon::parse($year.'-04-01')])->sum('total');
            $paidTemp = DB::table('payments')->whereBetween('payment_date', [Carbon::parse($year.'-03-01'), Carbon::parse($year.'-04-01')])->sum('amount');
            $usedTemp = DB::table('expenses')->whereBetween('date', [Carbon::parse($year.'-03-01'), Carbon::parse($year.'-04-01')])->sum('amount');
            array_push($areaBills, $billedTemp);
            array_push($areaPays, $paidTemp);
            array_push($areaExpenses, $usedTemp);
            array_push($areaMonths, 'Abril');
            $billedTemp = DB::table('bills')->whereBetween('created_at', [Carbon::parse($year.'-04-01'), Carbon::parse($year.'-05-01')])->sum('total');
            $paidTemp = DB::table('payments')->whereBetween('payment_date', [Carbon::parse($year.'-04-01'), Carbon::parse($year.'-05-01')])->sum('amount');
            $usedTemp = DB::table('expenses')->whereBetween('date', [Carbon::parse($year.'-04-01'), Carbon::parse($year.'-05-01')])->sum('amount');
            array_push($areaBills, $billedTemp);
            array_push($areaPays, $paidTemp);
            array_push($areaExpenses, $usedTemp);
            array_push($areaMonths, 'Mayo');
            $billedTemp = DB::table('bills')->whereBetween('created_at', [Carbon::parse($year.'-05-01'), Carbon::parse($year.'-06-01')])->sum('total');
            $paidTemp = DB::table('payments')->whereBetween('payment_date', [Carbon::parse($year.'-05-01'), Carbon::parse($year.'-06-01')])->sum('amount');
            $usedTemp = DB::table('expenses')->whereBetween('date', [Carbon::parse($year.'-05-01'), Carbon::parse($year.'-06-01')])->sum('amount');
            array_push($areaBills, $billedTemp);
            array_push($areaPays, $paidTemp);
            array_push($areaExpenses, $usedTemp);
            array_push($areaMonths, 'Junio');
            $billedTemp = DB::table('bills')->whereBetween('created_at', [Carbon::parse($year.'-06-01'), Carbon::parse($year.'-07-01')])->sum('total');
            $paidTemp = DB::table('payments')->whereBetween('payment_date', [Carbon::parse($year.'-06-01'), Carbon::parse($year.'-07-01')])->sum('amount');
            $usedTemp = DB::table('expenses')->whereBetween('date', [Carbon::parse($year.'-06-01'), Carbon::parse($year.'-07-01')])->sum('amount');
            array_push($areaBills, $billedTemp);
            array_push($areaPays, $paidTemp);
            array_push($areaExpenses, $usedTemp);
            array_push($areaMonths, 'Julio');
            $billedTemp = DB::table('bills')->whereBetween('created_at', [Carbon::parse($year.'-07-01'), Carbon::parse($year.'-08-01')])->sum('total');
            $paidTemp = DB::table('payments')->whereBetween('payment_date', [Carbon::parse($year.'-07-01'), Carbon::parse($year.'-08-01')])->sum('amount');
            $usedTemp = DB::table('expenses')->whereBetween('date', [Carbon::parse($year.'-07-01'), Carbon::parse($year.'-08-01')])->sum('amount');
            array_push($areaBills, $billedTemp);
            array_push($areaPays, $paidTemp);
            array_push($areaExpenses, $usedTemp);
            array_push($areaMonths, 'Agosto');
            $billedTemp = DB::table('bills')->whereBetween('created_at', [Carbon::parse($year.'-08-01'), Carbon::parse($year.'-09-01')])->sum('total');
            $paidTemp = DB::table('payments')->whereBetween('payment_date', [Carbon::parse($year.'-08-01'), Carbon::parse($year.'-09-01')])->sum('amount');
            $usedTemp = DB::table('expenses')->whereBetween('date', [Carbon::parse($year.'-08-01'), Carbon::parse($year.'-09-01')])->sum('amount');
            array_push($areaBills, $billedTemp);
            array_push($areaPays, $paidTemp);
            array_push($areaExpenses, $usedTemp);
            array_push($areaMonths, 'Septiembre');
            $billedTemp = DB::table('bills')->whereBetween('created_at', [Carbon::parse($year.'-09-01'), Carbon::parse($year.'-10-01')])->sum('total');
            $paidTemp = DB::table('payments')->whereBetween('payment_date', [Carbon::parse($year.'-09-01'), Carbon::parse($year.'-10-01')])->sum('amount');
            $usedTemp = DB::table('expenses')->whereBetween('date', [Carbon::parse($year.'-09-01'), Carbon::parse($year.'-10-01')])->sum('amount');
            array_push($areaBills, $billedTemp);
            array_push($areaPays, $paidTemp);
            array_push($areaExpenses, $usedTemp);
            array_push($areaMonths, 'Octubre');
            $billedTemp = DB::table('bills')->whereBetween('created_at', [Carbon::parse($year.'-10-01'), Carbon::parse($year.'-11-01')])->sum('total');
            $paidTemp = DB::table('payments')->whereBetween('payment_date', [Carbon::parse($year.'-10-01'), Carbon::parse($year.'-11-01')])->sum('amount');
            $usedTemp = DB::table('expenses')->whereBetween('date', [Carbon::parse($year.'-10-01'), Carbon::parse($year.'-11-01')])->sum('amount');
            array_push($areaBills, $billedTemp);
            array_push($areaPays, $paidTemp);
            array_push($areaExpenses, $usedTemp);
            array_push($areaMonths, 'Noviembre');
            $billedTemp = DB::table('bills')->whereBetween('created_at', [Carbon::parse($year.'-11-01'), Carbon::parse($year.'-12-01')])->sum('total');
            $paidTemp = DB::table('payments')->whereBetween('payment_date', [Carbon::parse($year.'-11-01'), Carbon::parse($year.'-12-01')])->sum('amount');
            $usedTemp = DB::table('expenses')->whereBetween('date', [Carbon::parse($year.'-11-01'), Carbon::parse($year.'-12-01')])->sum('amount');
            array_push($areaBills, $billedTemp);
            array_push($areaPays, $paidTemp);
            array_push($areaExpenses, $usedTemp);
            array_push($areaMonths, 'Diciembre');
            $billedTemp = DB::table('bills')->whereBetween('created_at', [Carbon::parse($year.'-12-01'), Carbon::parse(($year+1).'-01-01')])->sum('total');
            $paidTemp = DB::table('payments')->whereBetween('payment_date', [Carbon::parse($year.'-12-01'), Carbon::parse(($year+1).'-01-01')])->sum('amount');
            $usedTemp = DB::table('expenses')->whereBetween('date', [Carbon::parse($year.'-12-01'), Carbon::parse(($year+1).'-01-01')])->sum('amount');
            array_push($areaBills, $billedTemp);
            array_push($areaPays, $paidTemp);
            array_push($areaExpenses, $usedTemp);

         if (isset($_GET["fechaInicial"])) {
            $fechaInicial = $_GET['fechaInicial'];
            $fechaInicial = Carbon::parse($fechaInicial);
            $mesInicial = $fechaInicial->format('m');
            $diaInicial = $fechaInicial->format('d');
            $fechaFinal = $_GET['fechaFinal'];
            $fechaFinal = Carbon::parse($fechaFinal);
            $diaFinal = $fechaFinal->format('d');
            $mesFinal = $fechaFinal->format('m');
            $diff = $fechaInicial->diffInMonths($fechaFinal);
            if ($diaInicial>$diaFinal) {
              $diff++;
            }
            for ($i = 0; $i < $diff+1; $i++) {
              if ($i=0) {
                $lastMD = $fechaInicial->endOfMonth();
                $lastMD = $lastMD->addDay();
                $dateTempArray= $fechaInicial->locale('es')->translatedFormat('F y');
                $billedTemp = DB::table('bills')->whereBetween('created_at', [$fechaInicial, $lastMD])->sum('total');
                $paidTemp = DB::table('payments')->whereBetween('payment_date', [$fechaInicial, $lastMD])->sum('amount');
                $usedTemp = DB::table('expenses')->whereBetween('date', [$fechaInicial, $lastMD])->sum('amount');
                array_push($barBills, $billedTemp);
                array_push($barPays, $paidTemp);
                array_push($barExpenses, $usedTemp);
                array_push($barMonths, $dateTempArray);
              }elseif ($i=$diff) {
                $firstMD = $fechaFinal->startOfMonth();
                $dateTempArray= $fechaFinal->locale('es')->translatedFormat('F y');
                $billedTemp = DB::table('bills')->whereBetween('created_at', [$firstMD, $fechaFinal])->sum('total');
                $paidTemp = DB::table('payments')->whereBetween('payment_date', [$firstMD, $fechaFinal])->sum('amount');
                $usedTemp = DB::table('expenses')->whereBetween('date', [$firstMD, $fechaFinal])->sum('amount');
                array_push($barBills, $billedTemp);
                array_push($barPays, $paidTemp);
                array_push($barExpenses, $usedTemp);
                array_push($barMonths, $dateTempArray);
              }else{
                $fechaTurno = $fechaInicial->addMonths($i);
                $firstMD = $fechaTurno->startOfMonth();
                $lastMD = $fechaTurno->endOfMonth();
                $lastMD = $lastMD->addDay();
                $dateTempArray= $fechaTurno->locale('es')->translatedFormat('F y');
                $billedTemp = DB::table('bills')->whereBetween('created_at', [$firstMD, $lastMD])->sum('total');
                $paidTemp = DB::table('payments')->whereBetween('payment_date', [$firstMD, $lastMD])->sum('amount');
                $usedTemp = DB::table('expenses')->whereBetween('date', [$firstMD, $lastMD])->sum('amount');
                array_push($barBills, $billedTemp);
                array_push($barPays, $paidTemp);
                array_push($barExpenses, $usedTemp);
                array_push($barMonths, $dateTempArray);

              }
            }
          }

          return view('layouts.council_view',['barMonths'=>$barMonths,'barBills'=>$barBills,'barPays'=>$barPays,'barExpenses'=>$barExpenses,'areaMonths'=>$areaMonths,'areaBills'=>$areaBills,'areaPays'=>$areaPays,'areaExpenses'=>$areaExpenses,'billed'=>$billed,'paid'=>$paid,'used'=>$used]);
      }elseif ($request->session()->get('rank')=='Vigilante') {
          return redirect('minutas');
      }elseif ($request->session()->get('rank')) {
          switch (session('rank')) {
            case 'Encargado':
              $answer = adminph\Attendant::where('id',session('id'))->first();
              break;
            case 'Propietario':
              $answer = adminph\Propietary::where('id',session('id'))->first();
              break;
            case 'Arrendatario':
              $answer = adminph\Lessee::where('id',session('id'))->first();
              break;
            default:
              $answer = adminph\User::where('id',session('id'))->first();
              break;
          }
          $property = $answer->property;
          $organization = $answer->organization;
          $notaCredito = adminph\Concept::where('name','Nota credito')->first();
          $balance = 0;
          if ($notaCredito->id==$organization->first_id) {
            $balance -= $property->first_balance;
          }else{
            $balance += $property->first_balance;
          }
          if ($notaCredito->id==$organization->second_id) {
            $balance -= $property->second_balance;
          }else{
            $balance += $property->second_balance;
          }
          if ($notaCredito->id==$organization->third_id) {
            $balance -= $property->third_balance;
          }else{
            $balance += $property->third_balance;
          }
          if ($notaCredito->id==$organization->fourth_id) {
            $balance -= $property->fourth_balance;
          }else{
            $balance += $property->fourth_balance;
          }
          if ($notaCredito->id==$organization->fifth_id) {
            $balance -= $property->fifth_balance;
          }else{
            $balance += $property->fifth_balance;
          }
          if ($notaCredito->id==$organization->sixth_id) {
            $balance -= $property->sixth_balance;
          }else{
            $balance += $property->sixth_balance;
          }
          if ($notaCredito->id==$organization->seventh_id) {
            $balance -= $property->seventh_balance;
          }else{
            $balance += $property->seventh_balance;
          }
          if ($notaCredito->id==$organization->eighth_id) {
            $balance -= $property->eighth_balance;
          }else{
            $balance += $property->eighth_balance;
          }
          if ($notaCredito->id==$organization->nineth_id) {
            $balance -= $property->nineth_balance;
          }else{
            $balance += $property->nineth_balance;
          }
          if ($notaCredito->id==$organization->tenth_id) {
            $balance -= $property->tenth_balance;
          }else{
            $balance += $property->tenth_balance;
          }
          $saldo = $balance;
          $factura = adminph\Bill::where('property_id',$property->id)->orderBy('created_at','desc')->first();
          $pago = adminph\Payment::where('property_id',$property->id)->orderBy('payment_date','desc')->first();
          return view('layouts.user_view',['saldo'=>$saldo,'factura'=>$factura,'pago'=>$pago]);
      }else{
          return view('layouts.home');
      }
  }
    public function vistaUsuarios(Request $request){
    	if ($request->session()->get('rank')=='Admin') {
          $usuarios = adminph\User::all();
          $unidades = adminph\Organization::all();
          return view('layouts.users',['usuarios'=>$usuarios,'unidades'=>$unidades]);
    	}else{
    		return redirect('/');
    	}
	}
    public function vistaUnidades(Request $request){
    	if ($request->session()->get('rank')=='Admin') {
	    	$unidades = adminph\Organization::all();
	    	$conceptos = adminph\Concept::all();
	    	return view('layouts.organizations',['unidades'=>$unidades,'conceptos'=>$conceptos]);
    	}else{
    		return redirect('/');
    	}
	}
    public function vistaPropiedades(Request $request){
    	if ($request->session()->get('rank')=='Admin') {
	    	$unidades = adminph\Organization::all();
	    	return view('layouts.propertys',['unidades'=>$unidades]);
    	}else{
    		return redirect('/');
    	}
	}
    public function vistaPropietarios(Request $request){
    	if ($request->session()->get('rank')=='Admin') {
	    	$unidades = adminph\Organization::all();
	    	return view('layouts.propietarys',['unidades'=>$unidades]);
    	}else{
    		return redirect('/');
    	}
	}
    public function vistaArrendatarios(Request $request){
    	if ($request->session()->get('rank')=='Admin') {
	    	$unidades = adminph\Organization::all();
	    	return view('layouts.lessees',['unidades'=>$unidades]);
    	}else{
    		return redirect('/');
    	}
	}
    public function vistaEncargados(Request $request){
    	if ($request->session()->get('rank')=='Admin') {
	    	$unidades = adminph\Organization::all();
	    	return view('layouts.attendants',['unidades'=>$unidades]);
    	}else{
    		return redirect('/');
    	}
	}
    public function vistaBoletines(Request $request){
    	if ($request->session()->get('rank')) {
        if (session('rank')=='Admin') {
          $unidades = adminph\Organization::all();
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
          $unidades = adminph\Organization::where('id',$answer->organization_id)->get();
        }
	    	return view('layouts.bulletins',['unidades'=>$unidades]);
    	}else{
    		return redirect('/');
    	}
	}
    public function vistaAsambleas(Request $request){
    	if ($request->session()->get('rank')) {
        if (session('rank')=='Admin') {
          $unidades = adminph\Organization::all();
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
          $unidades = adminph\Organization::where('id',$answer->organization_id)->get();
        }
	    	return view('layouts.assemblys',['unidades'=>$unidades]);
    	}else{
    		return redirect('/');
    	}
	}
    public function vistaPagos(Request $request){
    	if ($request->session()->get('rank')) {
        if (session('rank')=='Admin') {
          $unidades = adminph\Organization::all();
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
          $unidades = adminph\Organization::where('id',$answer->organization_id)->get();
        }
	    	return view('layouts.payments',['unidades'=>$unidades]);
    	}else{
    		return redirect('/');
    	}
	}
    public function vistaGastos(Request $request){
      if ($request->session()->get('rank')) {
        if (session('rank')=='Admin') {
          $unidades = adminph\Organization::all();
        }else{
          $answer = adminph\User::find(session('id'));
          $unidades = adminph\Organization::where('code',$answer->code)->get();
        }
        return view('layouts.expenses',['unidades'=>$unidades]);
      }else{
        return redirect('/');
      }
  }
    public function vistaMinutas(Request $request){
      if (session('rank')=='Admin' || session('rank')=='Vigilante') {
        return view('layouts.minutes');
      }else{
        return redirect('/');
      }
  }
    public function vistaVisitantes(Request $request){
      if ($request->session()->get('rank')) {
        return view('layouts.guests');
      }else{
        return redirect('/');
      }
  }
    public function vistaReportesDaños(Request $request){
      if ($request->session()->get('rank')) {
        return view('layouts.damage_reports');
      }else{
        return redirect('/');
      }
  }
    public function vistaClasificados(Request $request){
      if ($request->session()->get('rank')) {
        if (session('rank')=='Admin') {
          return view('layouts.adds_admin');
        }elseif (session('rank') == 'Propietario' || session('rank')=='Encargado' || session('rank')=='Arrendatario') {
          return redirect('clasificados/1');
        }else{
          return redirect('/');
        }
      }else{
        return redirect('/');
      }
  }
    public function vistaClasificadosPagina($number=1){
      if (session('rank') == 'Propietario' || session('rank')=='Encargado' || session('rank')=='Arrendatario') {
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
        $skip = $number-1;
        $clasificados = adminph\Add::where('organization_id',$organization->id)->where('authorized',1)->skip($skip)->take(12)->get();
        $clasificados2 = adminph\Add::where('organization_id',$organization->id)->where('authorized',1)->get();
        if (count($clasificados2)>12) {
          $limite = 12;
        }else{
          $limite = count($clasificados2);
        }
        $count = count($clasificados2);
        $count = $count/12;
        $next = null;
        $prev = null;
        $countersHigh = null;
        $countersLow = null;
        if ($number>1){
          $prev = $number -1;
        }
        if ($number<$count){
          $next=$number+1;
        }
        if ($number<$count) {
          $countersHigh= array();
          $a=1;
          for ($i=$number+1; $i < $count+1 ; $i++) {
            if ($a <= 3) {
              $countersHigh[]=$i;
              $a++;
            }

          }
        }
        if ($number>1) {
          $countersLow= array();
          $a=1;
          for ($i=$number-3; $i < $number ; $i++) {
            if ($i>=1){
              if ($a <= 3) {
                $countersLow[]=$i;
                $a++;
              }
            }

          }
        }
        return view('layouts.adds_public',['clasificados'=>$clasificados,'prev'=>$prev,'countersHigh'=>$countersHigh,'number'=>$number,'countersLow'=>$countersLow,'next'=>$next]);
      }else{
        return redirect('/');
      }
    }
    public function vistaCorrespondencia(Request $request){
      if ($request->session()->get('rank')) {
        if (session('rank')=='Admin') {
          $unidades = adminph\Organization::all();
        }elseif ($request->session()->get('rank')=='Vigilante') {
          $answer = adminph\User::find(session('id'));
          $unidades = adminph\Organization::where('code',$answer->code)->get();
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
          $unidades = adminph\Organization::where('id',$answer->organization_id)->get();
        }
        return view('layouts.packages',['unidades'=>$unidades]);
      }else{
        return redirect('/');
      }
  }
    public function vistaFacturas(Request $request){
    	if ($request->session()->get('rank')) {
        if (session('rank')=='Admin') {
          $unidades = adminph\Organization::all();
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
          $unidades = adminph\Organization::where('id',$answer->organization_id)->get();
        }
	    	return view('layouts.bills',['unidades'=>$unidades]);
    	}else{
    		return redirect('/');
    	}
	}
    public function vistaReportes(Request $request){
      if ($request->session()->get('rank')=='Admin') {
        $unidades = adminph\Organization::all();
        return view('layouts.reports',['unidades'=>$unidades]);
      }else{ 
        return redirect('/');
      }
  }
    public function enrutadorReportes(Request $request){
      if ($request->session()->get('rank')=='Admin') {
        $momento = date("Y-m-d_h-i-s");
        switch ($_POST['report']) {
          case 1:
            $name = 'Control_pagos_'.$momento.'.xls';
            ControladorInformes::controlPagos($_POST['organization'],$name);
            break;
          case 2:
            $name = 'Estado_analitico_detallado_'.$momento.'.xls';
            ControladorInformes::estadoAnaliticoDetallado($_POST['organization'],$name);
            break;
          case 3:
            $name = 'Estado_cartera_concepto_'.$momento.'.xls';
            ControladorInformes::estadoCarteraConcepto($_POST['organization'],$name);
            break;
          case 4:
            $name = 'Estado_de_cuenta_'.$momento.'.xls';
            ControladorInformes::estadoCuenta($_POST['organization'],$name,$_POST['firstDate'],$_POST['secondDate']);
            break;
          case 5:
            $name = 'Movimiento_de_cartera_'.$momento.'.xls';
            ControladorInformes::movimientoCartera($_POST['organization'],$name,$_POST['firstDate'],$_POST['secondDate']);
            break;
          case 6:
            $name = 'Informe_facturacion_analitico_'.$momento.'.xls';
            ControladorInformes::informeFacturacionAnalitico($_POST['organization'],$name,$_POST['firstDate'],$_POST['secondDate']);
            break;
          case 7:
            $name = 'Listado_copropiedades_'.$momento.'.xls';
            ControladorInformes::listadoCopropiedades($_POST['organization'],$name);
            break;
          case 8:
            $name = 'Listado_notas_credito_'.$momento.'.xls';
            ControladorInformes::listadoNotasCredito($_POST['organization'],$name,$_POST['firstDate'],$_POST['secondDate']);
            break;
          case 9:
            $name = 'Listado_notas_debito_'.$momento.'.xls';
            ControladorInformes::listadoNotasDebito($_POST['organization'],$name,$_POST['firstDate'],$_POST['secondDate']);
            break;
          case 10:
            $name = 'Listado_pagos_'.$momento.'.xls';
            ControladorInformes::listadoPagos($_POST['organization'],$name,$_POST['firstDate'],$_POST['secondDate']);
            break;
          case 11:
            $name = 'Informe_facturacion_'.$momento.'.xls';
            ControladorInformes::informeFacturacion($_POST['organization'],$name,$_POST['firstDate'],$_POST['secondDate']);
            break;
          case 12:
            $name = 'Vencimiento_cartera_'.$momento.'.xls';
            ControladorInformes::vencimientoCartera($_POST['organization'],$name);
            break;
          default:
        return redirect('/');
            break;
        }
      }else{
        return redirect('/');
      }
  }
  public function facturaMasa(Request $request,$id){

      if ($request->session()->get('rank')=='Admin') {

      $unidad = adminph\Organization::find($id);
      $concepto = adminph\Concept::find($unidad->first_id);
      $conceptos[0]= $concepto;
      $concepto = adminph\Concept::find($unidad->second_id);
      $conceptos[1]= $concepto;
      $concepto = adminph\Concept::find($unidad->third_id);
      $conceptos[2]= $concepto;
      $concepto = adminph\Concept::find($unidad->fourth_id);
      $conceptos[3]= $concepto;
      $concepto = adminph\Concept::find($unidad->fifth_id);
      $conceptos[4]= $concepto;
      $concepto = adminph\Concept::find($unidad->sixth_id);
      $conceptos[5]= $concepto;
      $concepto = adminph\Concept::find($unidad->seventh_id);
      $conceptos[6]= $concepto;
      $concepto = adminph\Concept::find($unidad->eighth_id);
      $conceptos[7]= $concepto;
      $concepto = adminph\Concept::find($unidad->nineth_id);
      $conceptos[8]= $concepto;
      $concepto = adminph\Concept::find($unidad->tenth_id);
      $conceptos[9]= $concepto;
      date_default_timezone_set('America/Bogota');
      $month = date('m');
      $year = date('Y');
      setlocale(LC_TIME, 'es_ES');
      $fechaPago1 = date("Y-m-".$unidad->discount_day);
      $fechaCorte = adminph\Parameter::where('name','Dia Cierre')->first();
      $fechaPago2 = date("Y-m-".$fechaCorte->value);
      $propiedades = $unidad->propertys;
      $html='<html>
          }
        <head>
        <style>
        .center {
          text-align: center important!;
        }
        .end {
          text-align: end;
        }
        .start {
          text-align: start;
        }
        * {
          box-sizing: border-box;
        }
        img {
          display: block;
          margin-left: auto;
          margin-right: auto;
          max-width: 100%;
        }
        tr{
          width:100%;
        }
        .border-gray{
        border: 1px solid gray
        }
        td.backgroung-gray{
        border: 1px solid black; 
        background-color: gray
        }
        .border-black{
        border: 1px solid black
        }
        .row::after {
          content: "";
          clear: both;
          display: table;
        }
        [class*="col-"] {
          float: left;
          padding: 15px;
        }
        .font-size{
          font-size:40px;
        }
        .font-size-2{
          font-size:30px;
        }
        .font-size-3{
          font-size:12px;
        }
        .font-size-4{
          font-size:10px;
        }
        .font-size-5{
          font-size:11px;
        }
        .font-size-6{
          font-size:60px;
        }
        .font-size-7{
          font-size:70px;
        }
        .w-100{
          width:100%;
        }
        .pl{
          padding-left:5%
        }
        td.col-1 {width: 8.33%;}
        td.col-2 {width: 16.66%;}
        td.col-3 {width: 25%;}
        td.col-4 {width: 33.33%;}
        td.col-5 {width: 41.66%;}
        td.col-6 {width: 50%;}
        td.col-7 {width: 58.33%;}
        td.col-8 {width: 66.66%;}
        td.col-9 {width: 75%;}
        td.col-10 {width: 83.33%;}
        td.col-11 {width: 91.66%;}
        td.col-12 {width: 100%;}
        </style>
        </head>
        <body>';
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8', 
            'format' => [140, 216],
            'margin_top' => 14,
            'margin_bottom' => 14,
            'margin_header' => 0,
            'margin_footer' => 0,]);;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->shrink_tables_to_fit = 1;
        $mpdf->WriteHTML($html);
        $i=0;
      foreach ($propiedades as $key => $propiedad) {
        if ($propiedad->bill_state==1) {
          if ($i != 0) {
            $mpdf->AddPage();
          }
          $factura = adminph\Bill::where('property_id',$propiedad->id)->whereMonth('created_at',$month)->whereYear('created_at',$year)->first();
          if ($factura != null && $factura != "") {
            $propietario = $propiedad->propietary;
            $arrendatario = $propiedad->lessee;
            $encargado = $propiedad->attendant;
            $ultimoPago = adminph\Payment::where('property_id',$propiedad->id)->orderBy('payment_date','desc')->first();
            $periodo = $factura->created_at->format('M / Y');
            
            $pdfHTML=$this->writeBill(['factura'=>$factura,'unidad'=>$unidad,'propiedad'=>$propiedad,'propietario'=>$propietario,'arrendatario'=>$arrendatario,'encargado'=>$encargado,'conceptos'=>$conceptos,'fechaPago1'=>$fechaPago1,'fechaCorte'=>$fechaCorte,'fechaPago2'=>$fechaPago2,'periodo'=>$periodo,'ultimoPago'=>$ultimoPago]);

            $mpdf->WriteHTML($pdfHTML);
            $i++;
          }
        }
      }
        $html='
        </body>
        </html>';
        $mpdf->WriteHTML($html);
        $mpdf->Output();
      }else{
        return redirect('/');
      }
  }
    public function vistaFactura($id){
    	$factura = adminph\Bill::find($id);
    	if ($factura != null && $factura != "") {
    		$unidad = $factura->organization;
    		$propiedad = $factura->property;
    		$propietario = $propiedad->propietary;
    		$arrendatario = $propiedad->lessee;
    		$encargado = $propiedad->attendant;
        $concepto = adminph\Concept::find($unidad->first_id);
        $conceptos[0]= $concepto;
        $concepto = adminph\Concept::find($unidad->second_id);
        $conceptos[1]= $concepto;
        $concepto = adminph\Concept::find($unidad->third_id);
        $conceptos[2]= $concepto;
        $concepto = adminph\Concept::find($unidad->fourth_id);
        $conceptos[3]= $concepto;
        $concepto = adminph\Concept::find($unidad->fifth_id);
        $conceptos[4]= $concepto;
        $concepto = adminph\Concept::find($unidad->sixth_id);
        $conceptos[5]= $concepto;
        $concepto = adminph\Concept::find($unidad->seventh_id);
        $conceptos[6]= $concepto;
        $concepto = adminph\Concept::find($unidad->eighth_id);
        $conceptos[7]= $concepto;
        $concepto = adminph\Concept::find($unidad->nineth_id);
        $conceptos[8]= $concepto;
        $concepto = adminph\Concept::find($unidad->tenth_id);
        $conceptos[9]= $concepto;
    		$fechaPago1 = date("Y-m-".$unidad->discount_day);
    		$fechaCorte = adminph\Parameter::where('name','Dia Cierre')->first();
    		$fechaPago2 = date("Y-m-".$fechaCorte->value);
        $ultimoPago = adminph\Payment::where('property_id',$propiedad->id)->orderBy('payment_date','desc')->first();
    		setlocale(LC_TIME, 'es_ES');
    		$periodo = $factura->created_at->format('M / Y');
        $html='<html>
<head>
<style>
.center {
  text-align: center important!;
}
.end {
  text-align: end;
}
.start {
  text-align: start;
}
* {
  box-sizing: border-box;
}
img {
  display: block;
  margin-left: auto;
  margin-right: auto;
  max-width: 100%;
}
tr{
  width:100%;
}
.border-gray{
border: 1px solid gray
}
td.backgroung-gray{
border: 1px solid black; 
background-color: #bfbfbf
}
.border-black{
border: 1px solid black
}
.row::after {
  content: "";
  clear: both;
  display: table;
}
[class*="col-"] {
  float: left;
  padding: 15px;
}
.font-size{
  font-size:50px;
}
.font-size-2{
  font-size:40px;
}
.font-size-3{
  font-size:12px;
}
.font-size-4{
  font-size:10px;
}
.font-size-5{
  font-size:11px;
}
.font-size-6{
  font-size:60px;
}
.font-size-7{
  font-size:70px;
}
.w-100{
  width:100%;
}
.pl{
  padding-left:5%
}
td.col-1 {width: 8.33%;}
td.col-2 {width: 16.66%;}
td.col-3 {width: 25%;}
td.col-4 {width: 33.33%;}
td.col-5 {width: 41.66%;}
td.col-6 {width: 50%;}
td.col-7 {width: 58.33%;}
td.col-8 {width: 66.66%;}
td.col-9 {width: 75%;}
td.col-10 {width: 83.33%;}
td.col-11 {width: 91.66%;}
td.col-12 {width: 100%;}
</style>
</head>
<body>';
        $pdfHTML=$this->writeBill(['factura'=>$factura,'unidad'=>$unidad,'propiedad'=>$propiedad,'propietario'=>$propietario,'arrendatario'=>$arrendatario,'encargado'=>$encargado,'conceptos'=>$conceptos,'fechaPago1'=>$fechaPago1,'fechaCorte'=>$fechaCorte,'fechaPago2'=>$fechaPago2,'periodo'=>$periodo,'ultimoPago'=>$ultimoPago]);
        $html.=$pdfHTML;
        $html.='
</body>
</html>';
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8', 
            'format' => [140, 216],
            'margin_top' => 14,
            'margin_bottom' => 14,
            'margin_header' => 0,
            'margin_footer' => 0,]);;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->shrink_tables_to_fit = 1;
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    	}else{
    		return redirect('/');
    	}
	}

    public function vistaRecibo($id){
      $pago = adminph\Payment::find($id);
      if (is_object($pago)) {
        $propiedad = $pago->property;
        $validation = false;
        switch (session('rank')) {
          case 'Encargado':
            $reference = $propiedad->attendant;
            break;
          case 'Propietario':
            $reference = $propiedad->propietary;
            break;
          case 'Arrendatario':
            $reference = $propiedad->lessee;
            break;
          default:
            if (session('rank')=='Admin') {
              $validation = true;
            }
            break;
        }
        if ($validation==false&&session('id')==$reference->id) {
          $validation = true;
        }
        if ($validation==true) {
        $unidad = $pago->organization;
        $propiedad = $pago->property;
        $propietario = $propiedad->propietary;
        $valorLetras = adminph\NumeroALetras::convertir($pago->amount, 'pesos colombianos', 'centavos');
        $valorLetras .=' (COP).';
        setlocale(LC_TIME, 'es_ES');
        $codigo = $propiedad->apartment;
        while (strlen($codigo)<4) {
          $codigo = "0".$codigo;
        }
        $periodo = $pago->created_at->format('M / Y');
        $saldo = $propiedad->first_balance + $propiedad->second_balance + $propiedad->third_balance + $propiedad->fourth_balance + $propiedad->fifth_balance + $propiedad->sixth_balance + $propiedad->seventh_balance + $propiedad->eighth_balance + $propiedad->nineth_balance + $propiedad->tenth_balance;
        $html='<html>
        <head>
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato" />
        <style>
        * {
          box-sizing: border-box;
        }
        span{
          font-family: Lato !important;
          font-style: normal !important; 
          font-variant: normal !important;
        }
        table{
          border-collapse: separate; 
          border-spacing: 5px;
        }
        img {
          display: block;
          margin-left: auto !important;
          margin-right: auto !important;
          max-width: 100%;
        }
        tr{
          width:100%;
        }
        tr.blank_row{
          height:50px !important;
          background-color: #fff;
        }
        .border-bl{
          border-radius: 0px 0px 0px 35px !important;
        }
        .background-note-type{
          background-color: #E7530E;
          color: #fff;
          border-color: #E7530E;
          border-style: solid;
          border-width: 3px;
          border-radius: 0px 35px 0px 0px !important;
        }
        .background-note-1{
          background-color: #fff;
          color: #133250;
          border-color: #ECF2F6;
          border-style: solid;
          border-width: 1px;
        }
        .background-note-2{
          background-color: #EEF3F6;
          color: #133250;
          border-color: #EEF3F6;
          border-style: solid;
          border-width: 1px;
        }
        .background-note-3{
          background-color: #133250;
          color: #fff;
          border-color: #133250;
          border-style: solid;
          border-width: 1px;
        }
        .row::after {
          content: "";
          clear: both;
          display: table;
        }
        [class*="col-"] {
          float: left;
          padding: 15px;
        }
        .font-size-1{
          font-type:Lato;
          font-size:16px;
          font-style:bold;
        }
        .font-size-2{
          font-type:Lato;
          font-size:12px;
        }
        .font-size-3{
          font-type:Lato;
          font-size:10px;
        }
        .font-size-4{
          font-type:Lato;
          font-size:10px;
        }
        .font-size-5{
          font-type:Lato;
          font-size:10px;
          font-style:light;
        }
        .w-100{
          width:100%;
        }
        .pd{
          padding: 11px 10px;
        }
        td.col-1 {width: 8.33%;}
        td.col-2 {width: 16.66%;}
        td.col-3 {width: 25%;}
        td.col-4 {width: 33.33%;}
        td.col-5 {width: 41.66%;}
        td.col-6 {width: 50%;}
        td.col-7 {width: 58.33%;}
        td.col-8 {width: 66.66%;}
        td.col-9 {width: 75%;}
        td.col-10 {width: 83.33%;}
        td.col-11 {width: 91.66%;}
        td.col-12 {width: 100%;}
        </style>
        </head>
        <body>';
        $pdfHTML=$this->writeReceipt(['pago'=>$pago,'unidad'=>$unidad,'propiedad'=>$propiedad,'propietario'=>$propietario,'valorLetras'=>$valorLetras,'saldo'=>$saldo,'periodo'=>$periodo,'codigo'=>$codigo]);
        $html.=$pdfHTML;
        $html.='
        </body>
        </html>';
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8', 
            'format' => [140, 216],
            'margin_top' => 14,
            'margin_bottom' => 14,
            'margin_header' => 0,
            'margin_footer' => 0,]);;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->shrink_tables_to_fit = 1;
        $mpdf->WriteHTML($html);
        $mpdf->Output();
      }else{
        return redirect('/');
      }
      }else{
        return redirect('/');
      }
  }
    public function validacionDocumento($id){
      $nota = adminph\Document::find($id);
      if (is_object($nota)) {
      $propiedad = $nota->property;
      $validation = false;
        switch (session('rank')) {
          case 'Encargado':
            $reference = $propiedad->attendant;
            break;
          case 'Propietario':
            $reference = $propiedad->propietary;
            break;
          case 'Arrendatario':
            $reference = $propiedad->lessee;
            break;
          default:
            if (session('rank')=='Admin') {
              $validation = true;
            }
            break;
        }
        if ($validation==false&&session('id')==$reference->id) {
          $validation = true;
        }
        if ($validation==true) {
          $concepto = $nota->concept;
          switch ($concepto->name) {
            case 'Nota debito':
                $this->vistaNota($nota,$concepto->name);
              break;
            case 'Nota credito':    
                $this->vistaNota($nota,$concepto->name);
              break;       
            default:
                return redirect('/');
              break;
          }
        }
            else{
            return redirect('/');
          }
      }else{
        return redirect('/');
      }
    }
    public function vistaNota($nota,$concepto){
        $unidad = $nota->organization;
        $propiedad = $nota->property;
        $propietario = $propiedad->propietary;
        switch ($concepto) {
          case 'Nota debito':
              $textoCabeza ='A NOMBRE DE:';
              $concepto="NOTA<br>DÉBITO";
            break;
          case 'Nota credito':
              $textoCabeza ='A FAVOR DE:';
              $concepto="NOTA<br>CRÉDITO";
            break;       
          default:
              $textoCabeza ='A NOMBRE DE:';
            break;
        }
        $codigo = $propiedad->apartment;
        while (strlen($codigo)<4) {
          $codigo = "0".$codigo;
        }
        $valorLetras = adminph\NumeroALetras::convertir($nota->amount, 'pesos colombianos', 'centavos');
        $valorLetras .=' (COP).';
        setlocale(LC_TIME, 'es_ES');
        $periodoNum = $nota->created_at->format('yyyy-mm');
        $periodo = $nota->created_at->format('M / Y');
        $html='<html>
        <head>
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato" />
        <style>
        * {
          box-sizing: border-box;
        }
        span{
          font-family: Lato !important;
          font-style: normal !important; 
          font-variant: normal !important;
        }
        table{
          border-collapse: separate; 
          border-spacing: 5px;
        }
        img {
          display: block;
          margin-left: auto !important;
          margin-right: auto !important;
          max-width: 100%;
        }
        tr{
          width:100%;
        }
        tr.blank_row{
          height:50px !important;
          background-color: #fff;
        }
        .border-bl{
          border-radius: 0px 0px 0px 35px !important;
        }
        .background-note-type{
          background-color: #E7530E;
          color: #fff;
          border-color: #E7530E;
          border-style: solid;
          border-width: 3px;
          border-radius: 0px 35px 0px 0px !important;
        }
        .background-note-1{
          background-color: #fff;
          color: #133250;
          border-color: #ECF2F6;
          border-style: solid;
          border-width: 1px;
        }
        .background-note-2{
          background-color: #EEF3F6;
          color: #133250;
          border-color: #EEF3F6;
          border-style: solid;
          border-width: 1px;
        }
        .row::after {
          content: "";
          clear: both;
          display: table;
        }
        [class*="col-"] {
          float: left;
          padding: 15px;
        }
        .font-size-1{
          font-type:Lato;
          font-size:16px;
          font-style:bold;
        }
        .font-size-2{
          font-type:Lato;
          font-size:12px;
        }
        .font-size-3{
          font-type:Lato;
          font-size:10px;
        }
        .font-size-4{
          font-type:Lato;
          font-size:10px;
        }
        .font-size-5{
          font-type:Lato;
          font-size:10px;
          font-style:light;
        }
        .w-100{
          width:100%;
        }
        .pd{
          padding: 11px 10px;
        }
        td.col-1 {width: 8.33%;}
        td.col-2 {width: 16.66%;}
        td.col-3 {width: 25%;}
        td.col-4 {width: 33.33%;}
        td.col-5 {width: 41.66%;}
        td.col-6 {width: 50%;}
        td.col-7 {width: 58.33%;}
        td.col-8 {width: 66.66%;}
        td.col-9 {width: 75%;}
        td.col-10 {width: 83.33%;}
        td.col-11 {width: 91.66%;}
        td.col-12 {width: 100%;}
        </style>
        </head>
        <body>';
                $pdfHTML=$this->writeNote(['nota'=>$nota,'concepto'=>$concepto,'unidad'=>$unidad,'propiedad'=>$propiedad,'propietario'=>$propietario,'textoCabeza'=>$textoCabeza,'valorLetras'=>$valorLetras,'periodoNum'=>$periodoNum,'periodo'=>$periodo,'codigo'=>$codigo]);
                $html.=$pdfHTML;
                $html.='
        </body>
        </html>';
                $mpdf = new \Mpdf\Mpdf([
                    'mode' => 'utf-8', 
                    'format' => [140, 216],
                    'margin_top' => 14,
                    'margin_bottom' => 14,
                    'margin_header' => 0,
                    'margin_footer' => 0,]);;
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->shrink_tables_to_fit = 1;
                $mpdf->WriteHTML($html);
                $mpdf->Output();
        }
    public function vistaDocumentos(Request $request){
    	if ($request->session()->get('rank')) {
	    	$conceptos = adminph\Concept::all();
        if (session('rank')=='Admin') {
          $unidades = adminph\Organization::all();
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
          $unidades = adminph\Organization::where('id',$answer->organization_id)->get();
        }
	    	return view('layouts.documents',['unidades'=>$unidades,'conceptos'=>$conceptos]);
    	}else{
    		return redirect('/');
    	}
	}


    public function vistaParametros(Request $request){
		if ($request->session()->get('rank')=='Admin') {
	    	$parametros = adminph\Parameter::all();
	    	return view('layouts.parameters',['parametros'=>$parametros]);
		}else{
		    return redirect('/');
		}
	}
    public function vistaEmails(Request $request){
        if ($request->session()->get('rank')=='Admin') {
            return view('layouts.mails');
        }else{
            return redirect('/');
        }
    }




    private function writeBill($datos){
      $respuesta ='
    <table>
      <tr>
        <td class="border-black col-4" rowspan="4">
          <img src="'.$datos['unidad']->logo.'" alt="logotipo Unidad">
        </td>
        <td class="col-1" rowspan="6"></td>
        <td class="col-3 pl">
          <span class="font-size-2"><b>NIT: </b></span>
        </td>
        <td class="col-4 pl">
          <span class="font-size-2">'.$datos['unidad']->NIT.'</span>
        </td>
      </tr>
      <tr>
        <td class="col-3 pl" style="background: #bfbfbf; border: 1px solid black;">
          <span class="font-size-2"><b>Código Propiedad: </b></span>
        </td>
        <td class="col-4 pl border-gray">
          <span class="font-size-2">'.$datos['propiedad']->apartment.'</span>
        </td>
      </tr>
      <tr>
        <td class="col-3 pl" style="background: #bfbfbf; border: 1px solid black;">
          <span class="font-size-2"><b>Copropietario: </b></span>
        </td>
        <td class="col-4 pl border-gray">
          <span class="font-size-2">'.$datos['propietario']->name.'</span>
        </td>
      </tr>
      <tr>
        <td class="col-3 pl" style="background: #bfbfbf; border: 1px solid black;">
          <span class="font-size-2"><b>Identificación: </b></span>
        </td>
        <td class="col-4 pl border-gray">
          <span class="font-size-2">'.$datos['propiedad']->apartment.'</span>
        </td>
      </tr>
      <tr>
        <td class="col-3">
          <span class="font-size">Cuenta de cobro No:<br> <b>'.$datos['factura']->number.'</b></span>
        </td>
        <td class="col-3 pl" style="background: #bfbfbf; border: 1px solid black;">
          <span class="font-size-2"><b>Inquilino: </b></span>
        </td>
        <td class="col-4 pl border-gray">
           <span class="font-size-2">';
        if (is_object($datos['arrendatario'])) {
          if ($datos['arrendatario']->name != "" && $datos['arrendatario']->name != null) {
            $respuesta.=$datos['arrendatario']->name;
          }
        }
        $respuesta.='</span>
        </td>
      </tr>
      <tr>
        <td class="col-3">
          <span class="font-size">Periodo:<br>  <b>'.$datos['periodo'].'</b></span>
        </td>
        <td class="col-3 pl" style="background: #bfbfbf; border: 1px solid black;">
          <span class="font-size-2"><b>Dirección: </b></span>
        </td>
        <td class="col-4 pl border-gray">
          <span class="font-size-2">'.$datos['propietario']->address.'</span>
        </td>
      </tr>
    </table>
    <table class="w-100">
      <tr><td> </td></tr>
      <tr>
        <td style="text-align: center; background: #bfbfbf; border: 1px solid black;" class="col-5"><b class="font-size-5">CONCEPTO</span></td>
        <td style="text-align: center; background: #bfbfbf; border: 1px solid black;" class="col-4"><b class="font-size-5">MES ANTERIOR</span></td>
        <td style="text-align: center; background: #bfbfbf; border: 1px solid black;" class="col-3"><b class="font-size-5">MES ACTUAL</span></td>
      </tr>
      <tr>
        <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">'.$datos['conceptos'][0]->name.'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ '.number_format($datos['factura']->first_balance).'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ '.number_format($datos['factura']->first_concept).'</span></td>
      </tr>
      <tr>
        <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">'.$datos['conceptos'][1]->name.'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ '.number_format($datos['factura']->second_balance).'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ '.number_format($datos['factura']->second_concept).'</span></td>
      </tr>
      <tr>
        <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">'.$datos['conceptos'][2]->name.'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ '.number_format($datos['factura']->third_balance).'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ '.number_format($datos['factura']->third_concept).'</span></td>
      </tr>
      <tr>
        <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">'.$datos['conceptos'][3]->name.'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ '.number_format($datos['factura']->fourth_balance).'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ '.number_format($datos['factura']->fourth_concept).'</span></td>
      </tr>
      <tr>
        <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">'.$datos['conceptos'][4]->name.'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ '.number_format($datos['factura']->fifth_balance).'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ '.number_format($datos['factura']->fifth_concept).'</span></td>
      </tr>
      <tr>
        <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">'.$datos['conceptos'][5]->name.'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ '.number_format($datos['factura']->sixth_balance).'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ '.number_format($datos['factura']->sixth_concept).'</span></td>
      </tr>
      <tr>
        <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">'.$datos['conceptos'][6]->name.'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ '.number_format($datos['factura']->seventh_balance).'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ '.number_format($datos['factura']->seventh_concept).'</span></td>
      </tr>
      <tr>
        <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">'.$datos['conceptos'][7]->name.'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ '.number_format($datos['factura']->eighth_balance).'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ '.number_format($datos['factura']->eighth_concept).'</span></td>
      </tr>
      <tr>
        <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">'.$datos['conceptos'][8]->name.'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ '.number_format($datos['factura']->nineth_balance).'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ '.number_format($datos['factura']->nineth_concept).'</span></td>
      </tr>
      <tr>
        <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">'.$datos['conceptos'][9]->name.'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ '.number_format($datos['factura']->tenth_balance).'</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ '.number_format($datos['factura']->tenth_concept).'</span></td>
      </tr>
      <tr>
        <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">Descuento</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ 0</span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ '.number_format($datos['factura']->discount).'</span></td>
      </tr>
      <tr>
        <td style="text-align: center; border: 1px solid gray;" class="col-5"><span class="font-size-4"><b>TOTAL</b></span></td>
        <td style="text-align: right; border: 1px solid black; background: #bfbfbf" class="col-4"><span class="font-size-4"><b>$ '.number_format($datos['factura']->balance).'</b></span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4"><b>$ '.number_format($datos['factura']->total-$datos['factura']->balance).'</b></span></td>
      </tr>
    </table>
    <table class="w-100">
      <tr>
        <td style="text-align: left; border: 1px solid black; background: #bfbfbf" class="col-4"><span class="font-size-4"> PAGUE HASTA EL: </span></td>
        <td style="text-align: center; border: 1px solid gray;" class="col-3"><span class="font-size-4"> '.$datos['fechaPago1'].' </span></td>
        <td style="text-align: right; border: 1px solid black; background: #bfbfbf" class="col-5"><span class="font-size-4">$ '.number_format($datos['factura']->total-$datos['factura']->discount).'</span></td>
      </tr>
      <tr>
        <td style="text-align: left; border: 1px solid black; background: #bfbfbf" class="col-4"><span class="font-size-4"> PAGUE HASTA EL: </span></td>
        <td style="text-align: center; border: 1px solid gray;" class="col-3"><span class="font-size-4"> '.$datos['fechaPago2'].' </span></td>
        <td style="text-align: right; border: 1px solid black; background: #bfbfbf" class="col-5"><span class="font-size-4">$ '.number_format($datos['factura']->total).'</span></td>
      </tr>
    </table>
    <table class="w-100">
      <tr>
        <td style="text-align: left; border: 1px solid black; background: #bfbfbf" class="col-6"><span class="font-size-4"> VALOR PAGADO MES ANTERIOR </span></td>
        <td style="text-align: right; border: 1px solid gray;" class="col-6"><span class="font-size-4">$ ';
        if (is_object($datos['ultimoPago'])) {
          if ($datos['ultimoPago']->amount != "" && $datos['ultimoPago']->amount != null) {
            $respuesta.=number_format($datos['ultimoPago']->amount);
          }
          else{
            $respuesta.='0';
          }
        }else{
          $respuesta.='0';
        }
        $respuesta.='</span></td>
      </tr>
    </table>
    <table>
      <tr><td> </td></tr>
      <tr>
        <td class="col-7" style="text-align: left;"><span class="font-size-6">Consignar en la cuenta: '.$datos['unidad']->account_type.' número '.$datos['unidad']->account_number.' de '.$datos['unidad']->bank.'<br>Recuerde enviar su soporte de pago al correo: '.$datos['unidad']->email.'<br><b class="font-size-7">Consulte su factura en: <a href="https://propietarios.forzzeti.com">propietarios.forzzeti.com</a></b></span></td>
        <td class="col-3" style="text-align: justify;"><span class="font-size-7">';
          if ($datos['unidad']->link != "" && $datos['unidad']->link != null) {
            $respuesta.='También puede pagar su factura a través de PSE: ';
          };
          $respuesta.='</span></td>
        <td class="col-2">';
          if ($datos['unidad']->link != "" && $datos['unidad']->link != null) {
            $respuesta.='
          <a href="'.$datos['unidad']->link.'" target="_blank"><img src="Views/img/plantilla/BotonPSE.jpg" alt="Boton PSE"></a>';
          }
          else{
            $respuesta.='
          <a href="#"><img src="Views/img/plantilla/cuadro.jpg" alt="Cuadro blanco"></a>';
          }
        $respuesta.='</td>
      </tr>
    </table>
    <table class="w-100">
      <tr>
        <td class="col-12">
          <span class="font-size-4"><b>Referencia pago en banco: </b>'.$datos['propiedad']->apartment.'<br>Codigo baloto: ';
          if ($datos['unidad']->baloto_code != "" && $datos['unidad']->baloto_code != null) {
            $respuesta.=$datos['unidad']->baloto_code;
          }
          $respuesta.='<br>Codigo para pago Redeban: ';
          if ($datos['unidad']->redeban_code != "" && $datos['unidad']->redeban_code != null) {
            $respuesta.=$datos['unidad']->redeban_code;
          }
          $respuesta.='</span>
        </td>
      </tr>
      <tr>
        <td class="col-12" style="text-align: justify;border-bottom: 1px solid gray">
          <span class="font-size-4" style="text-align: center;">Si consigna despues del '.$datos['fechaCorte']->value.' su pago se registrara en el mes siguiente.</span><br><span class="font-size-4" style="text-align: justify;"><b>Recuerde que este documento no es una factura de venta. Es una cuenta de cobro. Somos entidad sin animo de lucro, exenta de retencion en la fuente y no contribuyente.</b></span>
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td class="col-1"></td>
        <td class="col-6"><span class="font-size-6" style="text-align:justify;">'.$datos['unidad']->message.'</span> </td>
        <td class="col-1"></td>
        <td class="col-1"></td>
        <td class="col-2"><img src="Views/img/plantilla/logo-negro.jpg" alt="Logotipo Forzzeti"></td>
        <td class="col-1"></td>
      </tr>
    </table>
    <table class="w-100">
      <tr>
        <td class="col-4" style="text-align: center; border-top: 1px solid gray">
          <span class="font-size-5" style="text-align: center"><b>PBX: </b>3173655526</span>
        </td>
        <td class="col-4" style="text-align: center; border-top: 1px solid gray">
          <span class="font-size-5" style="text-align: center"><b>info@forzzeti.com</b></span>
        </td>
        <td class="col-4" style="text-align: center; border-top: 1px solid gray">
          <span class="font-size-5" style="text-align: center"><b>www.forzzeti.com</b></span>
        </td>
      </tr>
    </table>';
      return $respuesta;
    }

    private function writeNote($datos){
      $respuesta ='
    <table class="w-100">
      <tr>
        <td class="col-4 background-note-1" rowspan="3" style="text-align:center"><img src="'.$datos['unidad']->logo2.'" alt="Logo"></td>
        <td style="text-align: center" class="col-3 background-note-2 pd" colspan="2"><span class="font-size-2"><b>'.$datos['unidad']->name.'</b></span></td>
        <td style="text-align: center" rowspan="2" class="col-2 background-note-type pd"><span class="font-size-1"><b>'.$datos['concepto'].'</b></span></td>
      </tr>
      <tr>
        <td style="text-align: center" class="col-3 background-note-2 pd" colspan="2"><span class="font-size-5">NIT: '.$datos['unidad']->NIT.'</span></td>
      </tr>
      <tr>
        <td style="text-align: center;" class="col-3 background-note-1 pd"><span class="font-size-3">PERIODO: '.$datos['periodoNum'].'</span></td>
        <td style="text-align: center;" class="col-3 background-note-1 pd"><span class="font-size-3">'.$datos['periodo'].'</span></td>
        <td style="text-align: center" class="col-2 background-note-2 pd"><span class="font-size-3"># '.$datos['nota']->number.'</span></td>
      </tr>
    </table>
    <table class="w-100" style="margin-top: -5px;">
      <tr>
        <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>'.$datos['textoCabeza'].' </b></span></td>
        <td class="col-6 background-note-1 pd" style="text-align:left"><span class="font-size-4">'.$datos['propietario']->name.'</span></td>
        <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>PROPIEDAD: </b></span></td>
        <td class="col-2 background-note-1 pd" style="text-align:left"><span class="font-size-4">'.$datos['codigo'].'</span></td>
      </tr>
      <tr>
        <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>VALOR: </b></span></td>
        <td class="col-10 background-note-1 pd" style="text-align:left" colspan="3"><span class="font-size-4">$ '.number_format($datos['nota']->amount,2).'</span></td>
      </tr>
      <tr>
        <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>VALOR EN LETRAS: </b></span></td>
        <td class="col-10 background-note-1 pd" style="text-align:left" colspan="3"><span class="font-size-4">'.$datos['valorLetras'].'</span></td>
      </tr>
      <tr>
        <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4" style="vertical-align: top;"><br><b>POR CONCEPTO DE: </b><br><br><br><br></span></td>
        <td class="col-10 background-note-1 pd" style="text-align:left" colspan="3"><span class="font-size-4">'.$datos['nota']->body.'</span></td>
      </tr>
      <tr>
        <td class="col-8 background-note-2 pd" style="text-align:left" colspan="2"><span class="font-size-4" valign="top"><b>NOTAS: </b></span></td>
        <td class="col-4 background-note-1" style="text-align:center" colspan="2"><img src="Views/img/plantilla/logo-nota.jpg" alt="Logo"></td>
      </tr>
    </table>';
      return $respuesta;
    }

    private function writeReceipt($datos){
      $respuesta ='
    <table class="w-100">
      <tr>
        <td class="col-4 background-note-1" rowspan="2" style="text-align:center"><img src="'.$datos['unidad']->logo2.'" alt="Logo"></td>
        <td style="text-align: center" class="col-3 background-note-2 pd" colspan="2"><span class="font-size-2"><b>'.$datos['unidad']->name.'</b></span><br><span class="font-size-5">NIT: '.$datos['unidad']->NIT.'</span><br><span class="font-size-5">DIRECCIÓN: '.$datos['unidad']->address.'</span></td>
        <td style="text-align: center" class="col-2 background-note-type ph"><div class="background-note-type border-tr pd" style="width:100%;height:100%"></div><span class="font-size-1"><b>RECIBO DE<br>CAJA</b></span></td>
      </tr>
      <tr>
        <td style="text-align: center;" class="col-3 background-note-1 pd"><span class="font-size-3">FECHA:  '.$datos['pago']->payment_date.'</span></td>
        <td style="text-align: center;" class="col-3 background-note-1 pd"><span class="font-size-3">CIUDAD: '.$datos['unidad']->city.'</span></td>
        <td style="text-align: center" class="col-2 background-note-2 pd"><span class="font-size-3"># '.$datos['pago']->number.'</span></td>
      </tr>
    </table>
    <table class="w-100" style="margin-top: -5px;">
      <tr>
        <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>RECIBIDO DE: </b></span></td>
        <td class="col-10 background-note-1 pd" style="text-align:left" colspan="4"><span class="font-size-4">'.$datos['propietario']->name.'</span></td>
      </tr>
      <tr>
        <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>APARTAMENTO: </b></span></td>
        <td class="col-4 background-note-1 pd" style="text-align:left"><span class="font-size-4">'.$datos['propiedad']->apartment.'</span></td>
        <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>VALOR: </b></span></td>
        <td class="col-4 background-note-1 pd" style="text-align:left" colspan="2"><span class="font-size-4">$ '.number_format($datos['pago']->amount,2).'</span></td>
      </tr>
      <tr>
        <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>CODIGO: </b></span></td>
        <td class="col-4 background-note-1 pd" style="text-align:left"><span class="font-size-4">'.$datos['codigo'].'</span></td>
        <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>VALOR EN LETRAS: </b></span></td>
        <td class="col-4 background-note-1 pd" style="text-align:left" colspan="2"><span class="font-size-4">'.$datos['valorLetras'].'</span></td>
      </tr>
      <tr>
        <td class="col-8 background-note-3 pd" style="text-align:center" colspan="3"><span class="font-size-4"><b>POR CONCEPTO DE: </b></span></td>
        <td class="col-2 background-note-3 pd" style="text-align:center"><span class="font-size-4"><b>VALOR</b></span></td>
        <td class="col-2 background-note-3 pd" style="text-align:center"><span class="font-size-4"><b>No. DOC REF.</b></span></td>
      </tr>
      <tr>
        <td class="col-8 background-note-2 pd" style="text-align:left" colspan="3"><span class="font-size-4">Pago de administración correspondiente al periodo '.$datos['periodo'].'</span></td>
        <td class="col-2 background-note-2 pd" style="text-align:left"><span class="font-size-4">$ '.number_format($datos['pago']->amount,2).'</span></td>
        <td class="col-2 background-note-2 pd" style="text-align:left"><span class="font-size-4">'.$datos['pago']->ref_document.'</span></td>
      </tr>
      <tr>
        <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>SALDO ACTUAL: </b></span></td>';
        if ($datos['saldo']<0) {
          $favor=$saldo * (-1);
        }else{
          $favor = 0;
        }
        $respuesta .= '<td class="col-6 background-note-1 pd" style="text-align:left" colspan="2"><span class="font-size-4">$ '.number_format($datos['saldo'],2).'</span></td>
        <td class="col-4 background-note-1" style="text-align:center" colspan="2" rowspan="3"><img src="Views/img/plantilla/logo-nota.jpg" alt="Logo"></td>
      </tr>
      <tr>
        <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>SALDO A FAVOR: </b></span></td>
        <td class="col-6 background-note-1 pd" style="text-align:left" colspan="2"><span class="font-size-4">$ '.number_format($favor,2).'</span></td>
      </tr>
      <tr>
        <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>PAGO PERIODO</b></span></td>
        <td class="col-6 background-note-1 pd" style="text-align:left" colspan="2"><span class="font-size-4">'.$datos['periodo'].'</span></td>
      </tr>
    </table>';
      return $respuesta;
    }


































/**
 *
 * Funciones de prueba quemadas
 *
 */

    public function vistaPrueba(Request $request){
        $inicio = Carbon::parse('22-08-2019');
        $diff = $inicio->locale('es')->translatedFormat('F y');
        echo $diff;
          // return view('booking.calendartry');
  }
    public function vistaDias(Request $request){
        $inicio = Carbon::parse('09-09-2019');
        $fin = Carbon::now();
        $diff = $inicio->diffInDays($fin);
        echo $diff;
      }
  // }
  // public function correoPrueba(){
  //   $to_name = 'Andrés Giraldo';
  //   $to_email = 'info@ptlab.co';
  //   $data = array('name'=>"Andres", "body" => "Este es un correo de prueba de adminph");
        
  //   Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
  //       $message->to($to_email, $to_name)
  //               ->subject('Correo de prueba adminph');
  //       $message->from('info@forzzeti.com','Bonieck de Forzzeti');
  //   });
  // }


//     public function pruebaFactura(){
//       $prueba = '<html>
// <head>
// <style>
// .center {
//   text-align: center important!;
// }
// .end {
//   text-align: end;
// }
// .start {
//   text-align: start;
// }
// * {
//   box-sizing: border-box;
// }
// img {
//   display: block;
//   margin-left: auto;
//   margin-right: auto;
//   max-width: 100%;
// }
// tr{
//   width:100%;
// }
// .border-gray{
// border: 1px solid gray
// }
// td.backgroung-gray{
// border: 1px solid black; 
// background-color: #bfbfbf
// }
// .border-black{
// border: 1px solid black
// }
// .row::after {
//   content: "";
//   clear: both;
//   display: table;
// }
// [class*="col-"] {
//   float: left;
//   padding: 15px;
// }
// .font-size{
//   font-size:40px;
// }
// .font-size-2{
//   font-size:30px;
// }
// .font-size-3{
//   font-size:12px;
// }
// .font-size-4{
//   font-size:10px;
// }
// .font-size-5{
//   font-size:11px;
// }
// .font-size-6{
//   font-size:60px;
// }
// .font-size-7{
//   font-size:70px;
// }
// .w-100{
//   width:100%;
// }
// .pl{
//   padding-left:5%
// }
// td.col-1 {width: 8.33%;}
// td.col-2 {width: 16.66%;}
// td.col-3 {width: 25%;}
// td.col-4 {width: 33.33%;}
// td.col-5 {width: 41.66%;}
// td.col-6 {width: 50%;}
// td.col-7 {width: 58.33%;}
// td.col-8 {width: 66.66%;}
// td.col-9 {width: 75%;}
// td.col-10 {width: 83.33%;}
// td.col-11 {width: 91.66%;}
// td.col-12 {width: 100%;}
// </style>
// </head>
// <body>
//     <table>
//       <tr>
//         <td class="border-black col-3" rowspan="4">
//           <img src="Views/img/organizaciones/maderos/maderos_2019-06-09_112453.jpg" alt="logotipo Unidad">
//         </td>
//         <td class="col-2" rowspan="6"></td>
//         <td class="col-3 pl">
//           <span class="font-size-2"><b>NIT: </b></span>
//         </td>
//         <td class="col-4 pl">
//           <span class="font-size-2">1234-6</span>
//         </td>
//       </tr>
//       <tr>
//         <td class="col-3 pl" style="background: #bfbfbf; border: 1px solid black;">
//           <span class="font-size-2"><b>Código Propiedad: </b></span>
//         </td>
//         <td class="col-4 pl border-gray">
//           <span class="font-size-2">123</span>
//         </td>
//       </tr>
//       <tr>
//         <td class="col-3 pl" style="background: #bfbfbf; border: 1px solid black;">
//           <span class="font-size-2"><b>Copropietario: </b></span>
//         </td>
//         <td class="col-4 pl border-gray">
//           <span class="font-size-2">Juan</span>
//         </td>
//       </tr>
//       <tr>
//         <td class="col-3 pl" style="background: #bfbfbf; border: 1px solid black;">
//           <span class="font-size-2"><b>Identificación: </b></span>
//         </td>
//         <td class="col-4 pl border-gray">
//           <span class="font-size-2">123</span>
//         </td>
//       </tr>
//       <tr>
//         <td class="col-3">
//           <span class="font-size">Cuenta de cobro No:<br> <b>1</b></span>
//         </td>
//         <td class="col-3 pl" style="background: #bfbfbf; border: 1px solid black;">
//           <span class="font-size-2"><b>Inquilino: </b></span>
//         </td>
//         <td class="col-4 pl border-gray">
//            <span class="font-size-2">Sergio </span>
//         </td>
//       </tr>
//       <tr>
//         <td class="col-3">
//           <span class="font-size">Periodo:<br>  <b>04/2019</b></span>
//         </td>
//         <td class="col-3 pl" style="background: #bfbfbf; border: 1px solid black;">
//           <span class="font-size-2"><b>Dirección: </b></span>
//         </td>
//         <td class="col-4 pl border-gray">
//           <span class="font-size-2">Calle 8 # 99</span>
//         </td>
//       </tr>
//     </table>
//     <table class="w-100">
//       <tr><td> </td></tr>
//       <tr>
//         <td style="text-align: center; background: #bfbfbf; border: 1px solid black;" class="col-5"><b class="font-size-5">CONCEPTO</span></td>
//         <td style="text-align: center; background: #bfbfbf; border: 1px solid black;" class="col-4"><b class="font-size-5">MES ANTERIOR</span></td>
//         <td style="text-align: center; background: #bfbfbf; border: 1px solid black;" class="col-3"><b class="font-size-5">MES ACTUAL</span></td>
//       </tr>
//       <tr>
//         <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">Concepto</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ 50.000</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ 100.000</span></td>
//       </tr>
//       <tr>
//         <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">Concepto</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ 50.000</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ 100.000</span></td>
//       </tr>
//       <tr>
//         <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">Concepto</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ 50.000</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ 100.000</span></td>
//       </tr>
//       <tr>
//         <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">Concepto</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ 50.000</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ 100.000</span></td>
//       </tr>
//       <tr>
//         <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">Concepto</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ 50.000</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ 100.000</span></td>
//       </tr>
//       <tr>
//         <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">Concepto</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ 50.000</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ 100.000</span></td>
//       </tr>
//       <tr>
//         <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">Concepto</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ 50.000</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ 100.000</span></td>
//       </tr>
//       <tr>
//         <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">Concepto</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ 50.000</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ 100.000</span></td>
//       </tr>
//       <tr>
//         <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">Concepto</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ 50.000</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ 100.000</span></td>
//       </tr>
//       <tr>
//         <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">Concepto</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ 50.000</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ 100.000</span></td>
//       </tr>
//       <tr>
//         <td style="text-align: left; border: 1px solid gray;" class="col-5"><span class="font-size-4">Descuento</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-4"><span class="font-size-4">$ 0</span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4">$ 5.000</span></td>
//       </tr>
//       <tr>
//         <td style="text-align: center; border: 1px solid gray;" class="col-5"><span class="font-size-4"><b>TOTAL</b></span></td>
//         <td style="text-align: right; border: 1px solid black; background: #bfbfbf" class="col-4"><span class="font-size-4"><b>$ 50.000</b></span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-3"><span class="font-size-4"><b>$ 100.000</b></span></td>
//       </tr>
//     </table>
//     <table class="w-100">
//       <tr>
//         <td style="text-align: left; border: 1px solid black; background: #bfbfbf" class="col-4"><span class="font-size-4"> PAGUE HASTA EL: </span></td>
//         <td style="text-align: center; border: 1px solid gray;" class="col-3"><span class="font-size-4"> 19 de abril </span></td>
//         <td style="text-align: right; border: 1px solid black; background: #bfbfbf" class="col-5"><span class="font-size-4">$ 100.000</span></td>
//       </tr>
//       <tr>
//         <td style="text-align: left; border: 1px solid black; background: #bfbfbf" class="col-4"><span class="font-size-4"> PAGUE HASTA EL: </span></td>
//         <td style="text-align: center; border: 1px solid gray;" class="col-3"><span class="font-size-4"> 29 de abril </span></td>
//         <td style="text-align: right; border: 1px solid black; background: #bfbfbf" class="col-5"><span class="font-size-4">$ 105.000</span></td>
//       </tr>
//     </table>
//     <table class="w-100">
//       <tr>
//         <td style="text-align: left; border: 1px solid black; background: #bfbfbf" class="col-6"><span class="font-size-4"> VALOR PAGADO MES ANTERIOR </span></td>
//         <td style="text-align: right; border: 1px solid gray;" class="col-6"><span class="font-size-4">$ 50.000</span></td>
//       </tr>
//     </table>
//     <table>
//       <tr><td> </td></tr>
//       <tr>
//         <td class="col-7" style="text-align: left;"><span class="font-size-6">Consignar en la cuenta: Ahorros número 123 de Bancolombia<br>Recuerde enviar su soporte de pago al correo: sumadre@gmail.com<br><b class="font-size-7">Consulte su factura en: <a href="https://propietarios.forzzeti.com">https://propietarios.forzzeti.com</a></b></span></td>
//         <td class="col-3" style="text-align: justify;"><span class="font-size-7">También puede pagar su factura a través de PSE: </span></td>
//         <td class="col-2">
//           <a href="https://avvillas.com" target="_blank"><img src="Views/img/plantilla/BotonPSE.jpg" alt="Boton PSE"></a></td>
//       </tr>
//     </table>
//     <table class="w-100">
//       <tr>
//         <td class="col-12">
//           <span class="font-size-4"><b>Referencia pago en banco: </b>123<br>Codigo baloto: 1234<br>Codigo para pago Redeban: 12345</span>
//         </td>
//       </tr>
//       <tr>
//         <td class="col-12" style="text-align: justify;border-bottom: 1px solid gray">
//           <span class="font-size-4" style="text-align: center;">Si consigna despues del 10 su pago se registrara en el mes siguiente.</span><br><span class="font-size-4" style="text-align: justify;"><b>Recuerde que este documento no es una factura de venta. Es una cuenta de cobro. Somos entidad sin animo de lucro, exenta de retencion en la fuente y no contribuyente.</b></span>
//         </td>
//       </tr>
//     </table>
//     <table>
//       <tr>
//         <td class="col-5"> </td>
//         <td class="col-2"><img src="Views/img/plantilla/logo-negro.jpg" alt="Logotipo Forzzeti"></td>
//         <td class="col-5"> </td>
//       </tr>
//     </table>
//     <table class="w-100">
//       <tr>
//         <td class="col-4" style="text-align: center; border-top: 1px solid gray">
//           <span class="font-size-5" style="text-align: center"><b>PBX: </b>3173655526</span>
//         </td>
//         <td class="col-4" style="text-align: center; border-top: 1px solid gray">
//           <span class="font-size-5" style="text-align: center"><b>info@forzzeti.com</b></span>
//         </td>
//         <td class="col-4" style="text-align: center; border-top: 1px solid gray">
//           <span class="font-size-5" style="text-align: center"><b>www.forzzeti.com</b></span>
//         </td>
//       </tr>
//     </table>
// </body>
// </html>';

//     $mpdf = new \Mpdf\Mpdf([
//         'mode' => 'utf-8', 
//         'format' => [140, 216],
//         'margin_top' => 10,
//         'margin_bottom' => 10,
//         'margin_left' => 10,
//         'margin_right' => 10,
//         'margin_header' => 0,
//         'margin_footer' => 0,]);;
//     $mpdf->SetDisplayMode('fullpage');
//     $mpdf->shrink_tables_to_fit = 1;
//     $mpdf->WriteHTML($prueba);
//     $mpdf->Output();
//     }

// public function pruebaNota(){
//       $prueba = '<html>
// <head>
// <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato" />
// <style>
// * {
//   box-sizing: border-box;
// }
// span{
//   font-family: Lato !important;
//   font-style: normal !important; 
//   font-variant: normal !important;
// }
// table{
//   border-collapse: separate; 
//   border-spacing: 5px;
// }
// img {
//   display: block;
//   margin-left: auto !important;
//   margin-right: auto !important;
//   max-width: 100%;
// }
// tr{
//   width:100%;
// }
// tr.blank_row{
//   height:50px !important;
//   background-color: #fff;
// }
// .border-bl{
//   border-radius: 0px 0px 0px 35px !important;
// }
// .background-note-type{
//   background-color: #E7530E;
//   color: #fff;
//   border-color: #E7530E;
//   border-style: solid;
//   border-width: 3px;
//   border-radius: 0px 35px 0px 0px !important;
// }
// .background-note-1{
//   background-color: #fff;
//   color: #133250;
//   border-color: #ECF2F6;
//   border-style: solid;
//   border-width: 1px;
// }
// .background-note-2{
//   background-color: #EEF3F6;
//   color: #133250;
//   border-color: #EEF3F6;
//   border-style: solid;
//   border-width: 1px;
// }
// .row::after {
//   content: "";
//   clear: both;
//   display: table;
// }
// [class*="col-"] {
//   float: left;
//   padding: 15px;
// }
// .font-size-1{
//   font-type:Lato;
//   font-size:16px;
//   font-style:bold;
// }
// .font-size-2{
//   font-type:Lato;
//   font-size:12px;
// }
// .font-size-3{
//   font-type:Lato;
//   font-size:10px;
// }
// .font-size-4{
//   font-type:Lato;
//   font-size:10px;
// }
// .font-size-5{
//   font-type:Lato;
//   font-size:10px;
//   font-style:light;
// }
// .w-100{
//   width:100%;
// }
// .pd{
//   padding: 11px 10px;
// }
// td.col-1 {width: 8.33%;}
// td.col-2 {width: 16.66%;}
// td.col-3 {width: 25%;}
// td.col-4 {width: 33.33%;}
// td.col-5 {width: 41.66%;}
// td.col-6 {width: 50%;}
// td.col-7 {width: 58.33%;}
// td.col-8 {width: 66.66%;}
// td.col-9 {width: 75%;}
// td.col-10 {width: 83.33%;}
// td.col-11 {width: 91.66%;}
// td.col-12 {width: 100%;}
// </style>
// </head>
// <body>
//     <table class="w-100">
//       <tr>
//         <td class="col-4 background-note-1" rowspan="3" style="text-align:center"><img src="Views/img/plantilla/logo-nota.jpg" alt="Logo"></td>
//         <td style="text-align: center" class="col-3 background-note-2 pd" colspan="2"><span class="font-size-2"><b>CONJUNTO RESIDENCIAL MADEROS DEL CAMPO 3 PH</b></span></td>
//         <td style="text-align: center" rowspan="2" class="col-2 border-tr background-note-type pd"><span class="font-size-1"><b>NOTA<br>CRÉDITO</b></span></td>
//       </tr>
//       <tr>
//         <td style="text-align: center" class="col-3 background-note-2 pd" colspan="2"><span class="font-size-5">NIT: 900.720.751-7</span></td>
//       </tr>
//       <tr>
//         <td style="text-align: center;" class="col-3 background-note-1 pd"><span class="font-size-3">PERIODO: 2019/03</span></td>
//         <td style="text-align: center;" class="col-3 background-note-1 pd"><span class="font-size-3">MARZO 2019</span></td>
//         <td style="text-align: center" class="col-2 background-note-2 pd"><span class="font-size-3"># 000000</span></td>
//       </tr>
//     </table>
//     <table class="w-100" style="margin-top: -5px;">
//       <tr>
//         <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>A FAVOR DE: </b></span></td>
//         <td class="col-6 background-note-1 pd" style="text-align:left"><span class="font-size-4">BEATRIZ HERRERA</span></td>
//         <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>PROPIEDAD: </b></span></td>
//         <td class="col-2 background-note-1 pd" style="text-align:left"><span class="font-size-4">0504</span></td>
//       </tr>
//       <tr>
//         <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>VALOR: </b></span></td>
//         <td class="col-10 background-note-1 pd" style="text-align:left" colspan="3"><span class="font-size-4">$ 138.000,00</span></td>
//       </tr>
//       <tr>
//         <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>VALOR EN LETRAS: </b></span></td>
//         <td class="col-10 background-note-1 pd" style="text-align:left" colspan="3"><span class="font-size-4">Ciento treinta y ocho mil</span></td>
//       </tr>
//       <tr>
//         <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4" style="vertical-align: top;"><br><b>POR CONCEPTO DE: </b><br><br><br><br></span></td>
//         <td class="col-10 background-note-1 pd" style="text-align:left" colspan="3"><span class="font-size-4">PAGO MAL ORGANIZADO</span></td>
//       </tr>
//       <tr>
//         <td class="col-8 background-note-2 pd" style="text-align:left" colspan="2"><span class="font-size-4" valign="top"><b>NOTAS: </b></span></td>
//         <td class="col-4 background-note-1" style="text-align:center" colspan="2"><img src="Views/img/plantilla/logo-nota.jpg" alt="Logo"></td>
//       </tr>
//     </table>
// </body>
// </html>';

//     $mpdf = new \Mpdf\Mpdf([
//         'mode' => 'utf-8', 
//         'format' => [216, 140],
//         'margin_top' => 8,
//         'margin_bottom' => 8,
//         'margin_left' => 8,
//         'margin_right' => 8,
//         'margin_header' => 0,
//         'margin_footer' => 0,]);;
//     $mpdf->SetDisplayMode('fullpage');
//     $mpdf->shrink_tables_to_fit=1;
//     $mpdf->WriteHTML($prueba);
//     $mpdf->Output();
//     }
// public function pruebaRecibo(){
//       $prueba = '<html>
// <head>
// <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato" />
// <style>
// * {
//   box-sizing: border-box;
// }
// span{
//   font-family: Lato !important;
//   font-style: normal !important; 
//   font-variant: normal !important;
// }
// table{
//   border-collapse: separate; 
//   border-spacing: 5px;
// }
// img {
//   display: block;
//   margin-left: auto !important;
//   margin-right: auto !important;
//   max-width: 100%;
// }
// tr{
//   width:100%;
// }
// tr.blank_row{
//   height:50px !important;
//   background-color: #fff;
// }
// .border-bl{
//   border-radius: 0px 0px 0px 35px !important;
// }
// .background-note-type{
//   background-color: #E7530E;
//   color: #fff;
//   border-color: #E7530E;
//   border-style: solid;
//   border-width: 3px;
//   border-radius: 0px 35px 0px 0px !important;
// }
// .background-note-1{
//   background-color: #fff;
//   color: #133250;
//   border-color: #ECF2F6;
//   border-style: solid;
//   border-width: 1px;
// }
// .background-note-2{
//   background-color: #EEF3F6;
//   color: #133250;
//   border-color: #EEF3F6;
//   border-style: solid;
//   border-width: 1px;
// }
// .background-note-3{
//   background-color: #133250;
//   color: #fff;
//   border-color: #133250;
//   border-style: solid;
//   border-width: 1px;
// }
// .row::after {
//   content: "";
//   clear: both;
//   display: table;
// }
// [class*="col-"] {
//   float: left;
//   padding: 15px;
// }
// .font-size-1{
//   font-type:Lato;
//   font-size:16px;
//   font-style:bold;
// }
// .font-size-2{
//   font-type:Lato;
//   font-size:12px;
// }
// .font-size-3{
//   font-type:Lato;
//   font-size:10px;
// }
// .font-size-4{
//   font-type:Lato;
//   font-size:10px;
// }
// .font-size-5{
//   font-type:Lato;
//   font-size:10px;
//   font-style:light;
// }
// .w-100{
//   width:100%;
// }
// .pd{
//   padding: 11px 10px;
// }
// td.col-1 {width: 8.33%;}
// td.col-2 {width: 16.66%;}
// td.col-3 {width: 25%;}
// td.col-4 {width: 33.33%;}
// td.col-5 {width: 41.66%;}
// td.col-6 {width: 50%;}
// td.col-7 {width: 58.33%;}
// td.col-8 {width: 66.66%;}
// td.col-9 {width: 75%;}
// td.col-10 {width: 83.33%;}
// td.col-11 {width: 91.66%;}
// td.col-12 {width: 100%;}
// </style>
// </head>
// <body>
//     <table class="w-100">
//       <tr>
//         <td class="col-4 background-note-1" rowspan="2" style="text-align:center"><img src="Views/img/plantilla/logo-nota.jpg" alt="Logo"></td>
//         <td style="text-align: center" class="col-3 background-note-2 pd" colspan="2"><span class="font-size-2"><b>CONJUNTO RESIDENCIAL MADEROS DEL CAMPO 3 PH</b></span><br><span class="font-size-5">NIT: 900.720.751-7</span><br><span class="font-size-5">DIRECCIÓN: CL 01A #12-34</span></td>
//         <td style="text-align: center" class="col-2 background-note-type ph"><div class="background-note-type border-tr pd" style="width:100%;height:100%"></div><span class="font-size-1"><b>RECIBO DE<br>CAJA</b></span></td>
//       </tr>
//       <tr>
//         <td style="text-align: center;" class="col-3 background-note-1 pd"><span class="font-size-3">FECHA:  02/18/2019</span></td>
//         <td style="text-align: center;" class="col-3 background-note-1 pd"><span class="font-size-3">CIUDAD: SABANETA</span></td>
//         <td style="text-align: center" class="col-2 background-note-2 pd"><span class="font-size-3"># 000000</span></td>
//       </tr>
//     </table>
//     <table class="w-100" style="margin-top: -5px;">
//       <tr>
//         <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>RECIBIDO DE: </b></span></td>
//         <td class="col-10 background-note-1 pd" style="text-align:left" colspan="4"><span class="font-size-4">BEATRIZ HERRERA</span></td>
//       </tr>
//       <tr>
//         <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>APARTAMENTO: </b></span></td>
//         <td class="col-4 background-note-1 pd" style="text-align:left"><span class="font-size-4">201</span></td>
//         <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>VALOR: </b></span></td>
//         <td class="col-4 background-note-1 pd" style="text-align:left" colspan="2"><span class="font-size-4">$ 6.000.000,00</span></td>
//       </tr>
//       <tr>
//         <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>CODIGO: </b></span></td>
//         <td class="col-4 background-note-1 pd" style="text-align:left"><span class="font-size-4">0201</span></td>
//         <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>VALOR EN LETRAS: </b></span></td>
//         <td class="col-4 background-note-1 pd" style="text-align:left" colspan="2"><span class="font-size-4">SEIS MILONES DE PESOS</span></td>
//       </tr>
//       <tr>
//         <td class="col-8 background-note-3 pd" style="text-align:center" colspan="3"><span class="font-size-4"><b>POR CONCEPTO DE: </b></span></td>
//         <td class="col-2 background-note-3 pd" style="text-align:center"><span class="font-size-4"><b>VALOR</b></span></td>
//         <td class="col-2 background-note-3 pd" style="text-align:center"><span class="font-size-4"><b>No. DOC REF.</b></span></td>
//       </tr>
//       <tr>
//         <td class="col-8 background-note-2 pd" style="text-align:left" colspan="3"><span class="font-size-4"></span></td>
//         <td class="col-2 background-note-2 pd" style="text-align:left"><span class="font-size-4"></span></td>
//         <td class="col-2 background-note-2 pd" style="text-align:left"><span class="font-size-4"></span></td>
//       </tr>
//       <tr>
//         <td class="col-8 background-note-2 pd" style="text-align:left" colspan="3"><span class="font-size-4"></span></td>
//         <td class="col-2 background-note-2 pd" style="text-align:left"><span class="font-size-4"></span></td>
//         <td class="col-2 background-note-2 pd" style="text-align:left"><span class="font-size-4"></span></td>
//       </tr>
//       <tr>
//         <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>SALDO ACTUAL: </b></span></td>
//         <td class="col-6 background-note-1 pd" style="text-align:left" colspan="2"><span class="font-size-4">$ 100.000,00</span></td>
//         <td class="col-4 background-note-1" style="text-align:center" colspan="2" rowspan="3"><img src="Views/img/plantilla/logo-nota.jpg" alt="Logo"></td>
//       </tr>
//       <tr>
//         <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>SALDO A FAVOR: </b></span></td>
//         <td class="col-6 background-note-1 pd" style="text-align:left" colspan="2"><span class="font-size-4">$ 100.000,00</span></td>
//       </tr>
//       <tr>
//         <td class="col-2 background-note-2 pd" style="text-align:right"><span class="font-size-4"><b>PAGO PERIODO</b></span></td>
//         <td class="col-6 background-note-1 pd" style="text-align:left" colspan="2"><span class="font-size-4">$ 2019/02</span></td>
//       </tr>
//     </table>
// </body>
// </html>';

//     $mpdf = new \Mpdf\Mpdf([
//         'mode' => 'utf-8', 
//         'format' => [216, 140],
//         'margin_top' => 8,
//         'margin_bottom' => 8,
//         'margin_left' => 8,
//         'margin_right' => 8,
//         'margin_header' => 0,
//         'margin_footer' => 0,]);;
//     $mpdf->SetDisplayMode('fullpage');
//     $mpdf->shrink_tables_to_fit=1;
//     $mpdf->WriteHTML($prueba);
//     $mpdf->Output();
//     }
//     private function checkLargeTables(&$doc)
// {
// //new code to split table large cells
// foreach ($doc->getElementsByTagName('table') as $table) {
// // iterate over each row in the table
// $trs = $table->getElementsByTagName('tr');
// $cloneArr = [];
// foreach ($trs as $tr) {
// $cloned = 0;
// foreach ($tr->getElementsByTagName('td') as $td) { // get the columns in this row
// if (strlen($td->textContent) > 2000) {
// $longValue = $td->nodeValue;
// $breaktill = strpos($td->nodeValue, '.', 1000);
// if ($cloned == 0) {
// $cloneNode = $tr->cloneNode(TRUE);
// $cloned = 1;
// $cloneArr[] = ["node" => $cloneNode, 'row' => $tr, 'breaktill' => $breaktill];
// }
// $td->textContent = substr($longValue, 0, $breaktill) . '. (cont.)';
// $td->setAttribute("style:", "white-space: nowrap");
// $td->setAttribute("width", "20%");

//       }
//     }
//   }

//   //here insert new nodes
//   foreach ($cloneArr as $cloneData) {
//     $this->insertNewNodes($cloneData, $table);    //this will be recursive function to split row multiple times if needed
//   }
// }
// return @$doc->saveHTML();
// }
}
