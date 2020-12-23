@extends('emails.mail')
@section('body')
<div class="row">
	<p>Mensaje para la administración del señor@ {{$nombre}}</p>
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
	<p>Asunto: {{$datos['newSubject']}}</p>
	<br>
	<p>{{$datos['newBody']}}</p>
	<br>
	<br>
	<br>
</div>
@stop