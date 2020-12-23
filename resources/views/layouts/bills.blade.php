@extends('base_table')
	@section('title')
		Facturas
	@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/facturas.js"></script>
@stop
@section('h1')
	Lista de Facturas
@stop
@section('small')
	Facturas
@stop
@section('texto1')
	Facturas
@stop
@if (session('rank')=='Admin')
  @section('cardHeader')
    <div class="form-group form-inline pull-left">
      <select class="custom-select unidadLimpiar" name="limpiar">
      @foreach($unidades as $unidad)
        <option value="{{$unidad->id}}">{{$unidad->code}}</option>
      @endforeach
      </select>
      <button class="btn btn-primary btnFacturasLimpiar"> Limpiar facturas del mes </button>
    </div>
    <div class="form-group form-inline pull-right">
      <button class="btn btn-primary2 mr-2" data-toggle="modal" data-target="#modalSubirFacturas"> Subir Facturas Anteriores </button>
      <button class='btn btn-secondary btnAplicarFacturas'><i class='fas fa-calculator'></i>   Aplicar Facturas Pendientes</button>
    </div>
  @stop
@endif
@section('nombreTabla') tablaFacturas @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Número Factura</th>
        <th>Unidad</th>
        <th>Apartamento</th>
        <th>Total</th>
        <th>Fecha Descuento</th>
        <th>Acciones</th>
      </tr>
    </thead>
@stop
@section('modalAgregar') "" @stop
@section('textoAgregar')
@stop
@section('formAdd')
@stop
@section('nameNew') "" @stop
@section('textoAgregar2')
@stop
@section('modalEditar') "" @stop
@section('actionEditar') "" @stop
@section('textoEditar')
@stop
@section('formEdit')
@stop
@section('nameEdit') "" @stop
@section('textoEditar2')
@stop
@section('moreForms')
    <!--=====================================
    =          Ventana Modal Edit         =
    ======================================-->
  <!-- The Modal -->
  <div class="modal" id="modalSubirFacturas">

      <div class="modal-dialog">

        <div class="modal-content">
            <form role="form" method="post" action="facturas/subir" enctype="multipart/form-data">
              @csrf
              <!-- Modal Header -->
              <div class="modal-header" style="background: #E75300 ; color: white">

                <h4 class="modal-title">Subir Facturas Anteriores</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <div class="box-body">
                  <!-- foto -->
                  <div class="form-group">
                    <div class="panel">SUBIR FACTURAS ANTERIORES</div>
                    <input type="file" class="facturas" name="facturas">
                    <p class="help-block">Ingrese el formato .CSV generado a partir de la plantilla de Excel</p>
                    
                  </div>
                </div>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

                <button type="submit" class="btn btn-success" name="newBills">Subir Facturas</button>
              </div>
          </form>

        </div>
      </div>
    </div>
@stop