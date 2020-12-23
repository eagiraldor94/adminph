@extends('emails.mail')
@section('body')
<div class="row">
	<p>Buen dia señor@ {{$nombre}},
	
	Forzzeti Property Management se permite informarle que ya se encuentra lista su factura del mes {{$mes}} de {{$año}}.
	Ante cualquier duda puede comunicarse a los datos que se encuentran en la firma.</p>
	
	Puede consultar la misma en nuestra plataforma de gestion o dando click en el siguiente boton.<br><br><br>
	<div class="row" style="width: 100%; text-align: center;"><a style="font-size: 20px" href="https://propietarios.forzzeti.com/clientes/facturas/{{$idFactura}}" class="btn btn-primary">Ver factura</a></div>
</div>
@stop