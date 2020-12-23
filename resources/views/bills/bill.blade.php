<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
<!--=====================================
=            CSS Plugins            =
======================================-->

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="Views/dist/css/adminlte.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="Views/plugins/bootstrap/css/bootstrap.css">
  <!--=====================================
=            Javascript Plugins            =
======================================-->


  <!-- jQuery -->
  <script src="Views/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery Number -->
  <script src="Views/plugins/jQueryNumber/jquery.number.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="Views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="Views/dist/js/adminlte.min.js"></script>
</head>
<body>
<!-- Site wrapper -->

    <div class="row"><h2><b>{{$unidad->name}}</b></h2></div>
    <div class="row">
      <div class="col-4" style="border: 1px solid black;">
        <img class="w-100" src="{{$unidad->logo}}" alt="logotipo Unidad">
        <div><b>Cuenta de cobro No: </b>{{$factura->number}}</div>
        <div><b>Periodo: </b>{{$periodo}}</div>
      </div>
      <div class="col-8">
        <div class="col-4">
          <div><h4><b>NIT: </b></h4></div>
          <div style="border: 1px solid black; background-color: gray"><div><b>Código Propiedad: </b></div></div>
          <div style="border: 1px solid black; background-color: gray"><div><b>Copropietario: </b></div></div>
          <div style="border: 1px solid black; background-color: gray"><div><b>Identificación: </b></div></div>
          <div style="border: 1px solid black; background-color: gray"><div><b>Inquilino: </b></div></div>
          <div style="border: 1px solid black; background-color: gray"><div><b>Dirección: </b></div></div>
        </div>
        <div class="col-8">
          <div><h4>{{$unidad->NIT}}</h4></div>
          <div style="border: 1px solid gray;"><div>{{$propiedad->apartment}}</div></div>
          <div style="border: 1px solid gray;"><div>{{$propietario->name}}</div></div>
          <div style="border: 1px solid gray;"><div>{{$propiedad->apartment}}</div></div>
          <div style="border: 1px solid gray;"><div>@if(is_object($arrendatario))@if($arrendatario->name != "" && $arrendatario->name != null) {{$arrendatario->name}} @endif @endif</div></div>
          <div style="border: 1px solid gray;"><div>{{$propietario->address}}</div></div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-6" style="border: 1px solid gray;">
          <div class="align-self-center" style="border: 1px solid black; background-color: gray"><h5><b>CONCEPTO</b></h5></div>
          @foreach($conceptos as $key => $concepto)
          <div class="align-self-start"> {{$concepto->name}} </div>
          @endforeach
          <div class="align-self-start"> DESCUENTO </div>
      </div>
      <div class="col-3" style="border: 1px solid gray;">
          <div class="align-self-center" style="border: 1px solid black; background-color: gray"><h5><b>SALDO ANTERIOR</b></h5></div>
          <div class="align-self-end"> $ {{number_format($propiedad->first_balance)}}</div>
          <div class="align-self-end"> $ {{number_format($propiedad->second_balance)}}</div>
          <div class="align-self-end"> $ {{number_format($propiedad->third_balance)}}</div>
          <div class="align-self-end"> $ {{number_format($propiedad->fourth_balance)}}</div>
          <div class="align-self-end"> $ {{number_format($propiedad->fifth_balance)}}</div>
          <div class="align-self-end"> $ {{number_format($propiedad->sixth_balance)}}</div>
          <div class="align-self-end"> $ {{number_format($propiedad->seventh_balance)}}</div>
          <div class="align-self-end"> $ {{number_format($propiedad->eighth_balance)}}</div>
          <div class="align-self-end"> $ {{number_format($propiedad->nineth_balance)}}</div>
          <div class="align-self-end"> $ {{number_format($propiedad->tenth_balance)}}</div>
          <div class="align-self-end"> $ {{number_format(0)}}</div>
      </div>
      <div class="col-3" style="border: 1px solid gray;">
          <div class="align-self-center" style="border: 1px solid black; background-color: gray"><h5><b>MES ACTUAL</b></h5></div>
          <div class="align-self-end"> $ {{number_format($factura->first_concept)}}</div>
          <div class="align-self-end"> $ {{number_format($factura->second_concept)}}</div>
          <div class="align-self-end"> $ {{number_format($factura->third_concept)}}</div>
          <div class="align-self-end"> $ {{number_format($factura->fourth_concept)}}</div>
          <div class="align-self-end"> $ {{number_format($factura->fifth_concept)}}</div>
          <div class="align-self-end"> $ {{number_format($factura->sixth_concept)}}</div>
          <div class="align-self-end"> $ {{number_format($factura->seventh_concept)}}</div>
          <div class="align-self-end"> $ {{number_format($factura->eighth_concept)}}</div>
          <div class="align-self-end"> $ {{number_format($factura->nineth_concept)}}</div>
          <div class="align-self-end"> $ {{number_format($factura->tenth_concept)}}</div>
          <div class="align-self-end"> $ {{number_format($factura->discount)}}</div>
      </div>
    </div>
    <div class="row">
      <div class="col-6">
          <div style="border: 1px solid gray;"><h5 class="align-self-center"><b> TOTAL </b></h5></div>
      </div>
      <div class="col-3">
          <div style="border: 1px solid black; background-color: gray"><h5 class="align-self-end"><b> {{number_format($factura->balance)}} </b></h5></div>
      </div>
      <div class="col-3">
          <div style="border: 1px solid gray;"><h5 class="align-self-end"><b> {{number_format($factura->total-$factura->balance)}} </b></h5></div>
      </div>
    </div>
    <div class="row">
      <div class="col-3">
          <div style="border: 1px solid black; background-color: gray"><h5 class="align-self-center"> PAGUE HASTA EL: </h5></div>
      </div>
      <div class="col-3">
          <div style="border: 1px solid gray;"><h5 class="align-self-center"> {{$fechaPago1}} </h5></div>
      </div>
      <div class="col-6">
          <div style="border: 1px solid black; background-color: gray"><h5 class="align-self-end"><b> $ {{number_format($factura->total-$factura->discount)}} </b></h5></div>
      </div>
    </div>
    <div class="row">
      <div class="col-3">
          <div style="border: 1px solid black; background-color: gray"><h5 class="align-self-center"> PAGUE HASTA EL: </h5></div>
      </div>
      <div class="col-3">
          <div style="border: 1px solid gray;"><h5 class="align-self-center"> {{$fechaPago2}} </h5></div>
      </div>
      <div class="col-6">
          <div style="border: 1px solid black; background-color: gray"><h5 class="align-self-end"><b> $ {{number_format($factura->total)}} </b></h5></div>
      </div>
    </div>
    <div class="row">
      <div class="col-6">
          <div style="border: 1px solid black; background-color: gray"><h5 class="align-self-center"> VALOR PAGADO EL MES ANTERIOR: </h5></div>
      </div>
      <div class="col-6">
          <div style="border: 1px solid gray;"><h5 class="align-self-end"><b> $@if(is_object($ultimoPago)) {{number_format($ultimoPago->amount)}} @else {{number_format(0)}} @endif</b></h5></div>
      </div>
    </div>
    <div class="row">
      <div class="col-8">
        <div><p>Consignar en la cuenta: {{$unidad->account_type}} número {{$unidad->account_number}} de {{$unidad->bank}} </p></div>
        <div><p>Recuerde enviar su soporte de pago al correo: {{$unidad->email}}</p></div>
        <div><h5><b>Consulte su factura en: <a href="https://propietarios.forzzeti.com">https://propietarios.forzzeti.com</a></b></h5></div>
        <div><p>Utilizando el usuario y contraseña suministrados por Forzzeti</p></div>
      </div>
      <div class="col-4">
        <div class="col-8">
          <p>También puede pagar su factura a través de PSE: </p>
        </div>
        <div class="col-4">
          <a href="{{$unidad->link}}" target="_blank"><img class="w-100" src="Views/img/plantilla/BotonPSE.jpg" alt="Boton PSE"></a>
        </div>
      </div>
    </div>
    <div class="row">
        <div><p><b>Referencia pago en banco: </b>{{$unidad->bank_reference}}</p></div>
        <div><p>Codigo baloto:@if($unidad->baloto_code != null) {{$unidad->baloto_code}} @endif</p></div>
        <div><p>Codigo para pago Redeban:@if($unidad->redeban_code != null) {{$unidad->redeban_code}} @endif</p></div>
    </div>
    <div class="row">
      <p>Si consigna despues del {{$fechaCorte}} su pago se registrara en el mes siguiente.</p>
      <p><b>Recuerde que este documento no es una factura de venta. Es una cuenta de cobro. Somos entidad sin animo de lucro, exenta de retencion en la fuente y no contribuyente.</b></p>
    </div>
    <div class="row" style="border-top: 1px solid gray; border-bottom: 1px solid gray;">
      <img class="w-50 align-self-center" src="Views/img/plantilla/logo-negro.jpg" alt="Logotipo Forzzeti">
    </div>
    <div class="row">
      <div class="col-4">
        <b>PBX: </b>3173655526
      </div>
      <div class="col-4">
        <b>info@forzzeti.com</b>
      </div>
      <div class="col-4">
        <b>www.forzzeti.com</b>
      </div>
    </div>
</body>
</html>