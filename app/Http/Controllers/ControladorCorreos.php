<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;
use adminph;
use Mail;

class ControladorCorreos extends Controller
{
    static public function ctrEnviarAsamblea($id){
      $assembly = adminph\Assembly::find($id);
      $organization = $assembly->organization;
      $propertys = $organization->propertys;
      foreach ($propertys as $key => $property) {
        $propietary = $property->propietary;
        $attendant = $property->attendant;
        setlocale(LC_TIME, 'es_ES');
        $to_name = $propietary->name;
        $to_email = $propietary->email1;
        $data = array('asunto'=>'Asamblea','nombre'=>$propietary->name,'asuntoAsamblea'=>$assembly->subject,'body'=>$assembly->body,'fecha'=>$assembly->assembly_date,'enlace'=>$assembly->link);
        if ($to_email != null && $to_email != "") {
          Mail::send('emails.assembly', $data, function($message) use ($to_name, $to_email, $property) {
              $message->to($to_email, $to_name)
                      ->subject('Notificación de asamblea');
              $message->from('info@forzzeti.com','Bonieck de Forzzeti');
            $mailLog = ControladorCorreos::ctrGuardarMail($to_email,'Notificación de asamblea',$property->id);
          });
        }
        $to_email = $propietary->email12;
        if ($to_email != null && $to_email != "") {
          Mail::send('emails.assembly', $data, function($message) use ($to_name, $to_email, $property) {
              $message->to($to_email, $to_name)
                      ->subject('Notificación de asamblea');
              $message->from('info@forzzeti.com','Bonieck de Forzzeti');
            $mailLog = ControladorCorreos::ctrGuardarMail($to_email,'Notificación de asamblea',$property->id);
          });
        }
        if($attendant!=null && $attendant!=""){
          if ($attendant->email != null && $attendant->email != "") {
            $to_name = $attendant->name;
            $to_email = $attendant->email;
            $data = array('asunto'=>'Asamblea','nombre'=>$attendant->name,'asuntoAsamblea'=>$assembly->subject,'body'=>$assembly->body,'fecha'=>$assembly->assembly_date,'enlace'=>$assembly->link);
            Mail::send('emails.assembly', $data, function($message) use ($to_name, $to_email, $property) {
                $message->to($to_email, $to_name)
                        ->subject('Notificación de asamblea');
                $message->from('info@forzzeti.com','Bonieck de Forzzeti');
              $mailLog = ControladorCorreos::ctrGuardarMail($to_email,'Notificación de asamblea',$property->id);
            });
          }
        }
      }
    }
    static public function ctrEnviarBoletin($id){
      $bulletin = adminph\Bulletin::find($id);
      $organization = $bulletin->organization;
      $propertys = $organization->propertys;
      foreach ($propertys as $key => $property) {
        $propietary = $property->propietary;
        $attendant = $property->attendant;
        $lessee = $property->lessee;
        setlocale(LC_TIME, 'es_ES');
        $to_name = $propietary->name;
        $to_email = $propietary->email1;
        $data = array('asunto'=>'Boletin','nombre'=>$propietary->name,'asuntoBoletin'=>$bulletin->subject,'body'=>$bulletin->body,'enlace'=>$bulletin->link);
        if ($to_email != null && $to_email != "") {
          Mail::send('emails.bulletin', $data, function($message) use ($to_name, $to_email, $property) {
              $message->to($to_email, $to_name)
                      ->subject('Notificación de boletin');
              $message->from('info@forzzeti.com','Bonieck de Forzzeti');
            $mailLog = ControladorCorreos::ctrGuardarMail($to_email,'Notificación de boletin',$property->id);
          });
        }
        $to_email = $propietary->email12;
        if ($to_email != null && $to_email != "") {
          Mail::send('emails.bulletin', $data, function($message) use ($to_name, $to_email, $property) {
              $message->to($to_email, $to_name)
                      ->subject('Notificación de boletin');
              $message->from('info@forzzeti.com','Bonieck de Forzzeti');
            $mailLog = ControladorCorreos::ctrGuardarMail($to_email,'Notificación de boletin',$property->id);
          });
        }
        if($attendant!=null && $attendant!=""){
          if ($attendant->email != null && $attendant->email != "") {
            $to_name = $attendant->name;
            $to_email = $attendant->email;
            $data = array('asunto'=>'Boletin','nombre'=>$attendant->name,'asuntoBoletin'=>$bulletin->subject,'body'=>$bulletin->body,'enlace'=>$bulletin->link);
            Mail::send('emails.bulletin', $data, function($message) use ($to_name, $to_email, $property) {
                $message->to($to_email, $to_name)
                        ->subject('Notificación de boletin');
                $message->from('info@forzzeti.com','Bonieck de Forzzeti');
              $mailLog = ControladorCorreos::ctrGuardarMail($to_email,'Notificación de boletin',$property->id);
            });
          }
        }
        if($lessee!=null && $lessee!=""){
          if ($lessee->email != null && $lessee->email != "") {
            $to_name = $lessee->name;
            $to_email = $lessee->email;
            $data = array('asunto'=>'Boletin','nombre'=>$lessee->name,'asuntoBoletin'=>$bulletin->subject,'body'=>$bulletin->body,'enlace'=>$bulletin->link);
            Mail::send('emails.bulletin', $data, function($message) use ($to_name, $to_email, $property) {
                $message->to($to_email, $to_name)
                        ->subject('Notificación de boletin');
                $message->from('info@forzzeti.com','Bonieck de Forzzeti');
              $mailLog = ControladorCorreos::ctrGuardarMail($to_email,'Notificación de boletin',$property->id);
            });
          }
        }
      }

    }
    static public function ctrEnviarFactura($id){
      $bill = adminph\Bill::find($id);
      $property = $bill->property;
      $propietary = $property->propietary;
      $attendant = $property->attendant;
      setlocale(LC_TIME, 'es_ES');
      $to_name = $propietary->name;
      $to_email = $propietary->email1;
      $data = array('asunto'=>'Facturación','nombre'=>$propietary->name, "mes" => $bill->created_at->format('M'),"año" => $bill->created_at->format('Y'),'idFactura'=>$bill->id);
      if ($to_email != null && $to_email != "") {
        Mail::send('emails.bill', $data, function($message) use ($to_name, $to_email, $property) {
            $message->to($to_email, $to_name)
                    ->subject('Notificación de factura');
            $message->from('info@forzzeti.com','Bonieck de Forzzeti');
          $mailLog = ControladorCorreos::ctrGuardarMail($to_email,'Notificación de factura',$property->id);
        });
      }
      $to_email = $propietary->email12;
      if ($to_email != null && $to_email != "") {
        Mail::send('emails.bill', $data, function($message) use ($to_name, $to_email, $property) {
            $message->to($to_email, $to_name)
                    ->subject('Notificación de factura');
            $message->from('info@forzzeti.com','Bonieck de Forzzeti');
          $mailLog = ControladorCorreos::ctrGuardarMail($to_email,'Notificación de factura',$property->id);
        });
      }
      if($attendant!=null && $attendant!=""){
        if ($attendant->email != null && $attendant->email != "") {
          $to_name = $attendant->name;
          $to_email = $attendant->email;
          $data = array('asunto'=>'Facturación','nombre'=>$attendant->name, "mes" => $bill->created_at->format('M'),"año" => $bill->created_at->format('Y'),'idFactura'=>$bill->id);
          Mail::send('emails.bill', $data, function($message) use ($to_name, $to_email, $property) {
              $message->to($to_email, $to_name)
                      ->subject('Notificación de factura');
              $message->from('info@forzzeti.com','Bonieck de Forzzeti');
            $mailLog = ControladorCorreos::ctrGuardarMail($to_email,'Notificación de factura',$property->id);
          });
        }
      }
    }
    static public function ctrActualizarDatos($rank,$id,$datos){
      switch ($rank) {
        case 'Encargado':
          $answer = adminph\Attendant::find($id);
          break;
        case 'Propietario':
          $answer = adminph\Propietary::find($id);
          break;
        case 'Arrendatario':
          $answer = adminph\Lessee::find($id);
          break;
        default:
          $answer = adminph\User::find($id);
          break;
      }
      $property = $answer->property;
      $organization = $answer->organization;
      setlocale(LC_TIME, 'es_ES');
      $to_name = $organization->name;
      $to_email = $organization->email1;
      $data = array('asunto'=>'Actualización de Datos','nombre'=>$answer->name, "unidad" => $organization->name,"apartamento" => $property->apartment,"rol" => $rank,'datos'=>$datos);
      if ($to_email != null && $to_email != "") {
        Mail::send('emails.update', $data, function($message) use ($to_name, $to_email, $property, $answer, $rank) {
            $message->to($to_email, $to_name)
                    ->subject('Actualización de datos');
            $message->from('info@forzzeti.com','Sistema Forzzeti');
            $asuntoLog = 'Actualización de datos del señor '.$answer->name.' '.$rank.' del apartamento '.$property->apartment;
            $mailLog = ControladorCorreos::ctrGuardarMail($to_email,$asuntoLog,$property->id);
        });
      }
    }
    static public function ctrMensajeAdmon($rank,$id,$datos){
      switch ($rank) {
        case 'Encargado':
          $answer = adminph\Attendant::find($id);
          break;
        case 'Propietario':
          $answer = adminph\Propietary::find($id);
          break;
        case 'Arrendatario':
          $answer = adminph\Lessee::find($id);
          break;
        default:
          $answer = adminph\User::find($id);
          break;
      }
      $property = $answer->property;
      $organization = $answer->organization;
      setlocale(LC_TIME, 'es_ES');
      $to_name = $organization->name;
      $to_email = $organization->email1;
      $data = array('asunto'=>'Mensaje para la administración','nombre'=>$answer->name, "unidad" => $organization->name,"apartamento" => $property->apartment,"rol" => $rank,'datos'=>$datos);
      if ($to_email != null && $to_email != "") {
        Mail::send('emails.message', $data, function($message) use ($to_name, $to_email, $property, $answer, $rank) {
            $numeroApartamento = "Apto ".$property->apartment;
            $message->to($to_email, $to_name)
                    ->subject('Mensaje para la administración');
            $message->from('info@forzzeti.com',$numeroApartamento);
            $asuntoLog = 'Mensaje para administración del señor '.$answer->name.' '.$rank.' del apartamento '.$property->apartment;
            $mailLog = ControladorCorreos::ctrGuardarMail($to_email,$asuntoLog,$property->id);
        });
      }
    }
    static public function ctrGuardarMail($email,$subject,$property){
    	$mail = new adminph\Mail();
    	$mail->property_id=$property;
    	$mail->subject=$subject;
    	$mail->email=$email;
    	$mail->save();
    }
    /*===============================================
    =            Mostrar tabla propiedades           =
    ===============================================*/
    
    public function ajaxDatatableCorreos()
    {   
    $productos = adminph\Mail::all();

    echo '{
            "data": [';

            for($i = 0; $i < count($productos)-1; $i++){
                echo '[
                  "'.($i+1).'",
                  "'.$productos[$i]->property->organization->code.'",
                  "'.$productos[$i]->property->apartment.'",
                  "'.$productos[$i]->subject.'",
                  "'.$productos[$i]->email.'",
                  "'.$productos[$i]->created_at.'"
                ],';

            }
                 echo '[
                  "'.(count($productos)).'",
                  "'.$productos[count($productos)-1]->property->organization->code.'",
                  "'.$productos[count($productos)-1]->property->apartment.'",
                  "'.$productos[count($productos)-1]->subject.'",
                  "'.$productos[count($productos)-1]->email.'",
                  "'.$productos[count($productos)-1]->created_at.'"
                ]
            ]
        }';
    }
}
