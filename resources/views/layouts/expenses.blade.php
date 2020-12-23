@extends('base_table')
	@section('title')
		Gastos de la unidad
	@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/gastos.js"></script>
@stop
@section('h1')
	Lista de Gastos
@stop
@section('small')
	Gastos
@stop
@section('texto1')
	Gastos
@stop
@section('cardHeader')
  @if (session('rank')=='Admin')
    <button class="btn btn-secondary pull-left" data-toggle="modal" data-target="#modalAgregarGasto"> Agregar Gasto </button>
  @endif
@stop
@section('nombreTabla') tablaGastos @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Unidad</th>
        <th>Concepto</th>
        <th>Referencia</th>
        <th>Monto</th>
        <th>Proveedor</th>
        <th>Tipo doc</th>
        <th>Documento</th>
        <th>Fecha</th>
        <th>Acciones</th>
      </tr>
    </thead>
@stop
@if (session('rank')=='Admin')
  @section('modalAgregar') "modalAgregarGasto" @stop
  @section('textoAgregar')
      Gasto
  @stop
  @section('formAdd')
    <div class="row">
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
            <div class="input-group-prepend d-md-inline-flex">
            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
            </div>
            <select id="nuevoIdOrganizacion" name="newOrganizationId" class="form-control" required>
              <option value="">Seleccione unidad</option>
              @foreach($unidades as $key => $unidad)
                <option value="{{$unidad->id}}">{{$unidad->name}}</option>
              @endforeach
            </select>
          </div>
       </div>
      <!--Documento referencia-->
        <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
        </div>
        <input class="form-control" type="text" name="newRefDocument" placeholder="Ingresar documento de referencia" id="nuevoDocumentoReferencia" title="Esta es la referencia del gasto, es decir, número de factura o cuenta de cobro" required>
      </div>
     </div>
     </div>
      <!-- Fecha pago -->
      <div class="row">
        <div class="form-group ml-3" style="width:45%">
          <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
          </div>
          <input class="form-control datepicker" type="text" name="newExpenseDate" id="nuevoFechaGasto" placeholder="Fecha del gasto" title="Fecha en que se realizó el pago del gasto" data-inputmask="'alias':'yyyy/mm/dd'" data-mask required>
          </div>
       </div>
      <div class="form-group ml-3" style="width: 45%">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
          </div>
          <input class="form-control" type="number" name="newAmount" placeholder="Ingrese monto del gasto" id="nuevoMonto" required>
        </div>
      </div>
   </div>
  <div class="row">
    <!-- Descripcion -->
  <div class="form-group ml-3" style="width: 93%">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
      </div>
      <textarea class="form-control" name="newDescription" placeholder="Describa el gasto (Concepto por el que se paga)" id="nuevoDescripcion" rows="3" required></textarea>
    </div>
  </div>
</div>
  <!-- nombre -->
  <div class="row">  
    <div class="form-group ml-3" style="width: 93%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-user"></i></span>
        </div>
        <input class="form-control" type="text" id="nuevoNombre" name="newName" placeholder="Ingresar nombre o razón social del proveedor" required>
      </div>
      
    </div>
  </div>
  <!-- Documento -->
  <div class="row">
    <div class="form-group ml-3" style="width:30%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
          </div>
          <select id="nuevoTipoDocumento" name="newIdType" class="form-control" required>
            <option value="">Tipo de documento</option>
            <option value="CC">Cedula de ciudadanía</option>
            <option value="CE">Cedula de extrajería</option>
            <option value="NIT">NIT</option>
          </select>
        </div>
     </div>
     <div class="form-group ml-3" style="width:60%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
          </div>
          <input type="text" class="form-control" name="newIdNumber" id="nuevoNumeroDocumento" placeholder="Número del documento" required>
        </div>
     </div>
   </div>
   <div class="row">
    <!-- foto -->
    <div class="form-group ml-3" style="width: 93%" title="Acá se debe subir la evidencia del gasto, factura o cuenta de cobro, ya sea escaneo o documento virtual, utilizar siempre formato PDF.">
      <div class="panel">SUBIR PRUEBA</div>
      <input type="file" class="document" name="document" required>
      <p class="help-block">Debe ser en formato PDF y con un peso máximo de 2MB</p>
    </div>
  </div>
  @stop
  @section('nameNew') "newExpense" @stop
  @section('textoAgregar2')
      Gasto
  @stop
@endif