<?php

namespace adminph\Http\Controllers;
use adminph;
use Illuminate\Http\Request;
use Session;
use LaravelGmail;
use Mail;

class ControladorUsuarios extends Controller
{
    /*=============================================
	=                    LOGIN               =
	=============================================*/
	
	
	static public function ctrIngresoUsuario(){
		
		if (isset($_POST['user']) && isset($_POST['pass'])) {
			if (preg_match('/^[a-zA-Z-0-9 ]+$/', $_POST['user'])) {
				switch ($_POST['rol']) {
					case 'Encargado':
						$answer = adminph\Attendant::where('username',$_POST['user'])->first();
						break;
					case 'Propietario':
						$answer = adminph\Propietary::where('username',$_POST['user'])->first();
						break;
					case 'Arrendatario':
						$answer = adminph\Lessee::where('username',$_POST['user'])->first();
						break;
					default:
						$answer = adminph\User::where('username',$_POST['user'])->first();
						break;
				}
				$password = $_POST["pass"];
				if (is_object($answer)) {
					if (password_verify($password,$answer->password) ) {
						if ($answer->state == 1) {
							if ($_POST['rol'] == 'Otro') {
								session(['rank' => $answer->type]);
							}else{
								session(['rank' => $_POST['rol']]);
							}
							session(['user' => $answer->username]);
							session(['name' => $answer->name]);
							session(['id' => $answer->id]);
							session(['photo' => $answer->photo]);
							/*=============================================
							=                  REGISTRAR LOGIN               =
							=============================================*/
							date_default_timezone_set('America/Bogota');
							session(['log' => date("Y-m-d h:i:s")]);
							$answer->last_log = session('log');
							if ($answer->save()) {
								echo ' <script>
							window.location = "inicio"; </script> ';

							}
							
						}else{
						echo '<br><div class="alert alert-warning" style="text-align: center;" >Este usuario se encuentra desactivado, por favor contacte al administrador.</div>';	
						}
						
						}
					}
				else{
					echo '<head><style type="text/css" media="screen">body{background:#4a6886;color:#fff;}</style></head><body><div class="alert alert-warning" style="text-align: center; font-size: 30px;margin-top:15%" >Las credenciales ingresadas no son correctas.</div><br><br><div style="text-align: center; margin-left: 35%;margin-top:5%; width:30%;background:#E75300; padding: 10px;"><a href="/">  <span style=" font-size: 18px; color: #fff"><b>Volver al inicio</b></span>  </a></div></body>';
				}
			}
		}
	}
	/*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearUsuario(){

		if (isset($_POST['newUser'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"]) &&
			   preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["newUsername"])) {
			   	/*======================================
			   	=            Validar Imagen            =
			   	======================================*/
			   	$ruta="";
			   	if (isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name'])) {
			   		list($ancho,$alto) = getimagesize($_FILES['photo']['tmp_name']);
			   		$nuevoAncho = 500;
			   		$nuevoAlto = 500;
			   		/*==========================================
			   		=            CREANDO DIRECTORIO            =
			   		==========================================*/
			   		$directorio = "Views/img/usuarios/".$_POST['newUsername'];
			   		mkdir($directorio,0755);
			   		/*===========================================================================
			   		=            Funciones defecto PHP dependiendo de tipo de imagen            =
			   		===========================================================================*/
			   		switch ($_FILES['photo']['type']) {
			   			case 'image/jpeg':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newUsername'].'_'.$preruta.'.jpg';
			   				$origen = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				break;
			   			case 'image/png':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newUsername'].'_'.$preruta.'.png';
			   				$origen = imagecreatefrompng($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagepng($destino,$ruta);
			   				break;
			   			default:
			   				# code...
			   				break;
			   		}
			   		
			   		
			   	}
			   	$answer = new adminph\User();
			   	$answer->name = $_POST['newName'];
			   	$answer->username = $_POST['newUsername'];
			   	$answer->password = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
			   	$answer->type = $_POST['rol'];
			   	$answer->code = $_POST['newOrganizationCode'];
			   	$answer->photo = $ruta;
			   if ($answer->save()) {
			   	return redirect('usuarios');
			   }
			 } else {
			 	return view('layouts.users_error');
			 }
		}

	}
	/*===================================
	=            USER EDIT            =
	===================================*/
	
	static public function ctrEditarUsuario(){

		if (isset($_POST['editUser'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"])) {
			   	/*======================================
			   	=            Validar Imagen             =
			   	======================================*/
			   	$ruta=$_POST['lastPhoto'];
			   	if (isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name'])) {
			   		list($ancho,$alto) = getimagesize($_FILES['photo']['tmp_name']);
			   		$nuevoAncho = 500;
			   		$nuevoAlto = 500;
			   		/*==========================================
			   		=            CREANDO DIRECTORIO            =
			   		==========================================*/
			   		$directorio = "Views/img/usuarios/".$_POST['newUsername'];
			   		if (!empty($_POST['lastPhoto'])) {
			   			unlink($_POST['lastPhoto']);
			   		}else{
			   			mkdir($directorio,0755);
			   		}
			   		
			   		
			   		/*===========================================================================
			   		=            Funciones defecto PHP dependiendo de tipo de imagen            =
			   		===========================================================================*/
			   		switch ($_FILES['photo']['type']) {
			   			case 'image/jpeg':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newUsername'].'_'.$preruta.'.jpg';
			   				$origen = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				break;
			   			case 'image/png':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newUsername'].'_'.$preruta.'.png';
			   				$origen = imagecreatefrompng($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagepng($destino,$ruta);
			   				break;
			   			default:
			   				# code...
			   				break;
			   		}
			   		
			   		
			   	}
				$answer = adminph\User::where('username',$_POST['newUsername'])->first();
			   	if ($_POST['newPassword'] != "") {
			   		$password = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
			   	}else{
			   		$password=$_POST['password'];
			   	}
			   	$answer->name = $_POST['newName'];
			   	$answer->username = $_POST['newUsername'];
			   	$answer->password = $password;
			   	$answer->type = $_POST['rol'];
			   	$answer->code = $_POST['newOrganizationCode'];
			   	$answer->photo = $ruta;
			   if ($answer->save()) {
			   	return redirect('usuarios');			   }
			 } else {
			 	return view('layouts.users_error');
			 }
		}

	}
	/*======================================
	=            Borrar usuario            =
	======================================*/
	static public function ctrBorrarUsuario(){
		if (isset($_POST['idUsuario'])) {
			if ($_POST['fotoUsuario'] != "") {
				unlink($_POST["fotoUsuario"]);
				rmdir('Views/img/usuarios/'.$_POST['usuario']);
			}
		$answer=adminph\User::find($_POST['idUsuario']);
		$answer->delete();
		}
	}
	static public function ctrSacarUsuario(){
		Session::flush();
		return redirect('/');
	}
	public function ajaxEditarUsuario(){
		$answer = adminph\User::find($_POST['idUsuario']);
		echo json_encode($answer);
	} 
	public function ajaxEditarme(){
		switch (session('rank')) {
			case 'Encargado':
				$answer = adminph\Attendant::find($_POST['idUsuario']);
				break;
			case 'Propietario':
				$answer = adminph\Propietary::find($_POST['idUsuario']);
				break;
			case 'Arrendatario':
				$answer = adminph\Lessee::find($_POST['idUsuario']);
				break;
			default:
				$answer = adminph\User::find($_POST['idUsuario']);
				break;
		}
		echo json_encode($answer);
	} 
	public function ajaxActivarUsuario(){
		$answer = adminph\User::find($_POST['activarUsuario']);
		$answer->state = $_POST['estadoUsuario'];
		$answer->save();
	} 
	public function ajaxCheckearUsuario(){
		$answer = adminph\User::where('username',$_POST['userCheck'])->first();
		echo json_encode($answer);
	} 
	public function ctrEditarme($rank,$id){
		switch ($rank) {
			case 'Encargado':
				$answer = adminph\Attendant::find($id);
				$folder = 'encargados';
				break;
			case 'Propietario':
				$answer = adminph\Propietary::find($id);
				$folder = 'propietarios';
				break;
			case 'Arrendatario':
				$answer = adminph\Lessee::find($id);
				$folder = 'arrendatarios';
				break;
			default:
				$answer = adminph\User::find($id);
				$folder = 'usuarios';
				break;
		}

		if (isset($_POST['editUser']) && $_POST['password']==$answer->password) {
			   	/*======================================
			   	=            Validar Imagen             =
			   	======================================*/
			   	$ruta=$answer->photo;
			   	if (isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name'])) {
			   		list($ancho,$alto) = getimagesize($_FILES['photo']['tmp_name']);
			   		$nuevoAncho = 500;
			   		$nuevoAlto = 500;
			   		/*==========================================
			   		=            CREANDO DIRECTORIO            =
			   		==========================================*/
			   		$directorio = "Views/img/".$folder."/".$answer->username;
			   		if (!empty($answer->photo)) {
			   			unlink($answer->photo);
			   		}else{
			   			mkdir($directorio,0755);
			   		}
			   		
			   		
			   		/*===========================================================================
			   		=            Funciones defecto PHP dependiendo de tipo de imagen            =
			   		===========================================================================*/
			   		switch ($_FILES['photo']['type']) {
			   			case 'image/jpeg':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$answer->username.'_'.$preruta.'.jpg';
			   				$origen = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				break;
			   			case 'image/png':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$answer->username.'_'.$preruta.'.png';
			   				$origen = imagecreatefrompng($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagepng($destino,$ruta);
			   				break;
			   			default:
			   				# code...
			   				break;
			   		}
			   		
			   		
			   	}
			   	if ($_POST['newPassword'] != "") {
			   		$password = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
			   	}else{
			   		$password=$answer->password;
			   	}
			   	$answer->password = $password;
			   	$answer->photo = $ruta;
			   	$answer->save();
			   	return redirect('/');		
		}
	} 
	public function ctrInfo($rank,$id){
		$datos = $_POST;
	   	$mail = ControladorCorreos::ctrActualizarDatos($rank,$id,$datos);
	   	return redirect('/');
	}
	public function ctrMensaje($rank,$id){
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

		if (isset($_POST['newMessage']) && $_POST['password']==$answer->password) {
			$datos = $_POST;
		   	$mail = ControladorCorreos::ctrMensajeAdmon($rank,$id,$datos);
		   	return redirect('/');
			   	
		}
	}
}
