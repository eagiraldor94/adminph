@extends('emails.mail')
@section('body')
<div class="row">
	<p>Solicitud de actualización de datos del señor@ {{$nombre}}</p>
	<br>
	<br>
	<br>
	<br>
	<p>Unidad = {{$unidad}}</p>
	<br>
	<p>Apartamento = {{$apartamento}}</p>
	<br>
	<p>Tipo de usuario = {{$rol}}</p>
	<br>
	<p>Nombre = {{$datos['newName']}}</p>
	<br>
	<p>Tipo de documento = {{$datos['newIdType']}}</p>
	<br>
	<p>Número de documento = {{$datos['newIdNumber']}}</p>
	<br>
	<p>Teléfono 1 = {{$datos['newPhone1']}}</p>
	<br>
	<p>Teléfono 2 = {{$datos['newPhone2']}}</p>
	<br>
	<p>Email 1 = {{$datos['newEmail1']}}</p>
	<br>
	<p>Email 2 = {{$datos['newEmail2']}}</p>
	<br>
	<p>Dirección de notificación = {{$datos['newAddress']}}</p>
	<br>
	<br>
	<br>
</div>
@stop