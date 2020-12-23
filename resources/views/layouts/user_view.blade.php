@extends('base_layout')
@section('title')
	Home
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/home.js"></script>
@stop
@section('content')
	  <div class="content-wrapper">
	    <!-- Content Header (Page header) -->
	    <section class="content-header">
	      <div class="container-fluid">
	        <div class="row m-2">
	        	<div class="col-lg-2 my-auto text-center">
	              @if(session('photo') != "" && session('photo') != null)
	                  <img src="{{session('photo')}}" class="img-fluid img-circle" alt="User Image">
	              @else
	                  <img src="Views/img/usuarios/anonymous.png" class="img-fluid img-circle" alt="User Image">
	              @endif
	        	</div>
	        	<div class="col-lg-5 my-auto">
	        		<h4>Bienvenido al Sistema de administración para Copropietarios de Forzzeti señor@ {{session('name')}}</h4>
	        	</div>
	        	<div class="col-lg-5 my-auto">
	        		<h6><b>Su saldo es: </b>$ {{number_format($saldo,2)}}</h6>
	        		<h6><b>Su ultima factura es por : </b>$ {{number_format($factura->total,2)}}. Con descuento antes de {{$factura->discount_date}}</h6>
	        		<h6><b>Su ultimo pago es por: </b>$ {{number_format($pago->amount,2)}}. Registrado el dia {{$pago->payment_date}}</h6>
	        	</div>
	        </div>
	      </div>
	      <!-- /.container-fluid -->
	    </section>

	    <!-- Main content -->
	    <section class="content">

	      <div class="row m-3">
			<!-- Small boxes (Stat box) -->
			<div class="col-lg-3 col-6 col-xs-12">
			  <!-- small box -->
			  <div class="small-box bg-primary">
			    <div class="inner">
		            <h3> Última </h3>
		            <p> factura </p>
			    </div>
			    <div class="icon mt-4">
			      <i class="fas fa-file-invoice-dollar"></i>
			    </div>
			    <a target="_blank" href="clientes/facturas/{{$factura->id}}" class="small-box-footer">Ir al PDF	<i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6 col-xs-12">
			  <!-- small box -->
			  <div class="small-box bg-gray">
			    <div class="inner">
		            <h3> Recibo </h3>
		            <p> de caja </p>
			    </div>
			    <div class="icon mt-4">
			      <i class="fas fa-receipt"></i>
			    </div>
			    <a href="#" class="small-box-footer">Ir al PDF	<i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6 col-xs-12">
			  <!-- small box -->
			  <div class="small-box bg-gray">
			    <div class="inner">
		            <h3> Estado </h3>
		            <p> de cuenta </p>
			    </div>
			    <div class="icon mt-4">
			      <i class="fas fa-balance-scale"></i>
			    </div>
			    <a href="#" class="small-box-footer">Ver detalle	<i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6 col-xs-12">
			  <!-- small box -->
			  <div class="small-box bg-secondary2">
			    <div class="inner">
		            <h3> Mensaje </h3>
		            <p> para la administración </p>
			    </div>
			    <div class="icon mt-4">
			      <i class="fas fa-envelope"></i>
			    </div>
			    <a data-toggle="modal" data-target="#modalEnviarMensaje" class="small-box-footer">Enviar mensaje	<i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
		</div>


      <div class="row m-3"><div class="col-12 pt-3" style="text-align: center;"><div class="btn btn-dark btnMostrarMas"> Ver más opciones </div></div></div>
			{{-- OPCIONES OCULTAS





			 --}}
			<!-- ./col -->
			<!-- Small boxes (Stat box) -->
		<div class="row m-3">
			<div class="col-lg-3 col-6 col-xs-12 d-none opcionOculta">
			  <!-- small box -->
			  <div class="small-box bg-primary">
			    <div class="inner">
		            <h3> Facturas </h3>
		            <p> propiedad </p>
			    </div>
			    <div class="icon mt-4">
			      <i class="fas fa-file-invoice-dollar"></i>
			    </div>
			    <a href="facturas" class="small-box-footer">Ver más		<i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6 col-xs-12 d-none opcionOculta">
			  <!-- small box -->
			  <div class="small-box bg-primary2">
			    <div class="inner">
		            <h3> Documentos </h3>
		            <p> y certificados </p>
			    </div>
			    <div class="icon mt-4">
			      <i class="fas fa-file-pdf"></i>
			    </div>
			    <a href="documentos" class="small-box-footer">Ver más	 <i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6 col-xs-12 d-none opcionOculta">
			  <!-- small box -->
			  <div class="small-box bg-secondary">
			    <div class="inner">
		            <h3> Actualización </h3>
		            <p> de datos </p>
			    </div>
			    <div class="icon mt-4">
			      <i class="fas fa-user-cog"></i>
			    </div>
			    <a data-toggle="modal" data-target="#modalEditarInfo" class="small-box-footer">Ver formulario	<i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6 col-xs-12 d-none opcionOculta">
			  <!-- small box -->
			  <div class="small-box bg-secondary2">
			    <div class="inner">
		            <h3> Boletines </h3>
		            <p> unidad </p>
			    </div>
			    <div class="icon mt-4">
			      <i class="fas fa-clipboard-list"></i>
			    </div>
			    <a href="boletines" class="small-box-footer">Ver más 	<i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
		</div>
		<div class="row m-3">
			<!-- Small boxes (Stat box) -->
			<div class="col-lg-3 col-6 col-xs-12 d-none opcionOculta">
			  <!-- small box -->
			  <div class="small-box bg-primary">
			    <div class="inner">
		            <h3> Asambleas </h3>
		            <p> unidad </p>
			    </div>
			    <div class="icon mt-4">
			      <i class="fas fa-bullhorn"></i>
			    </div>
			    <a href="asambleas" class="small-box-footer">Ver más 	<i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6 col-xs-12 d-none opcionOculta">
			  <!-- small box -->
			  <div class="small-box bg-gray">
			    <div class="inner">
		            <h3> Reportes </h3>
		            <p> unidad </p>
			    </div>
			    <div class="icon mt-4">
			      <i class="fas fa-exclamation-triangle"></i>
			    </div>
			    <a href="#" class="small-box-footer">Ver formulario		<i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6 col-xs-12 d-none opcionOculta">
			  <!-- small box -->
			  <div class="small-box bg-gray">
			    <div class="inner">
		            <h3> Autorizacion </h3>
		            <p> de ingreso </p>
			    </div>
			    <div class="icon mt-4">
			      <i class="fas fa-lock-open"></i>
			    </div>
			    <a href="#" class="small-box-footer">Ver más 	<i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6 col-xs-12 d-none opcionOculta">
			  <!-- small box -->
			  <div class="small-box bg-gray">
			    <div class="inner">
		            <h3> Zonas </h3>
		            <p> comúnes </p>
			    </div>
			    <div class="icon mt-4">
			      <i class="fas fa-tree"></i>
			    </div>
			    <a href="#" class="small-box-footer">Ir a reserva  <i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
		</div>
		<div class="row m-3">
			<!-- Small boxes (Stat box) -->
			<div class="col-6 d-none opcionOculta">
			  <!-- small box -->
			  <div class="small-box bg-gray">
			    <div class="inner">
			      <h3> Clasificados </h3>
			    </div>
			    <div class="icon mt-4">
			      <i class="fas fa-newspaper"></i>
			    </div>
			    <a href="#" class="small-box-footer">Ver clasificados 	<i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
			<!-- ./col -->
			<div class="col-6 d-none opcionOculta">
			  <!-- small box -->
			  <div class="small-box bg-gray">
			    <div class="inner">
            		<h3> Correspondencia </h3>	
			    </div>
			    <div class="icon mt-4">
			      <i class="fas fa-shipping-fast"></i>
			    </div>
			    <a href="#" class="small-box-footer">Ver más 	<i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
	      </div>
	      
	    </section>
	    <!-- /.content -->
	  </div>
	  <!-- /.content-wrapper -->
	@include('layouts.message')
	@include('layouts.info_update')
@stop