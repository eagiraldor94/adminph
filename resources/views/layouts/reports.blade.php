@extends('base_layout')
@section('title')
	Reportes
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/reportes.js"></script>
@stop
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Seleccione el reporte
                <small>y la fecha</small></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                <li class="breadcrumb-item active">Reportes</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <section class="content">
<!-- Default box -->
      <div class="card mb-5 pb-5 text-center">
        <form role="form" method="post" action="reportes/descargar" enctype="multipart/form-data" target="_blank">
          @csrf
        <div class="card-header bg-primary">
              <div class="form-group m-auto" style="width: 100%">
                <div class="input-group">
                  <button type="button" class="btn btn-default" id="daterange-btn2">
                    <span id="reportrange2"><i class="fa fa-calendar"></i> Rango de fecha</span>
                    <i class="fa fa-caret-down"></i>
                  </button>
                  <input type="hidden" name="firstDate" id="firstDate">
                  <input type="hidden" name="secondDate" id="secondDate">
                </div>
              </div>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="form-group ml-3" style="width: 93%">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-file-excel"></i></span>
                  </div>
                  <select class="form-control" name="report">
                    <option value="">Seleccione el tipo de informe</option>
                    <option value="1">Control pagos</option>
                    <option value="2">Estado analitíco detallado</option>
                    <option value="3">Estado de cartera por concepto</option>
                    <option value="4">Estado de cuenta</option>
                    <option value="5">Movimiento de cartera</option>
                    <option value="6">Informe de facturación analítico</option>
                    <option value="7">Listado de copropiedades</option>
                    <option value="8">Listado de notas crédito</option>
                    <option value="9">Listado de notas débito</option>
                    <option value="10">Listado de pagos</option>
                    <option value="11">Informe de facturación</option>
                    <option value="12">Vencimiento de cartera</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group ml-3" style="width: 93%">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                  </div>
                  <select class="form-control" name="organization">
                    <option value="">Seleccione la unidad</option>
                    @foreach($unidades as $unidad)
                    <option value="{{$unidad->id}}">{{$unidad->code}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
        </div>
        <div class="card-footer">
          <div class="row w-100">
            <div class="form-group text-center" style="width: 100%">
              <div class="input-group justify-content-center">
                <button type="submit" class="btn btn-success" name="newReport">Descargar reporte</button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->

        </form>
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@stop