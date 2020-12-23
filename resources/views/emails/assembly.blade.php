@extends('emails.mail')
@section('body')
<div class="row">
	<p>Buen dia señor@ {{$nombre}},
	
	Forzzeti Property Management se permite informarle acerca de una nueva asamblea.</p>

	<h3 class="align-self-center"><b>Asunto: </b>{{$asuntoAsamblea}}</h3>

	<p>{{$body}}</p>
	
	<h5><b>Fecha: </b>{{$fecha}}</h5>
	
	<p>Ante cualquier duda puede comunicarse a los datos que se encuentran en la firma.</p>
	
	Puede consultar la misma en nuestra plataforma de gestion o dando click en el siguiente boton.<br><br><br>
	<div class="row" style="width: 100%; text-align: center;">
	<a style="font-size: 20px;" @if($enlace != null && $enlace != "") href="https://propietarios.forzzeti.com/{{$enlace}}"@else href="https://propietarios.forzzeti.com"@endif class="btn btn-primary">Ver asamblea</a></div>

</div>
@stop