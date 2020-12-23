@extends('base_table')
	@section('title')
		Pagos
	@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/pagos.js"></script>
@stop
@section('h1')
	Lista de Pagos
@stop
@section('small')
	Pagos
@stop
@section('texto1')
	Pagos
@stop
@section('cardHeader')
  @if (session('rank')=='Admin')
    <button class="btn btn-secondary pull-left" data-toggle="modal" data-target="#modalAgregarPago"> Agregar Pago </button>
    <div class="form-group form-inline pull-right">
      <button class="btn btn-primary2 mr-2" data-toggle="modal" data-target="#modalSubirPagos"> Subir Pagos </button>
      <button class="btn btn-primary" data-toggle="modal" data-target="#modalPagosAnteriores"> Subir Pagos Antiguos </button>
    </div>
  @endif
@stop
@section('nombreTabla') tablaPagos @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Unidad</th>
        <th>Apartamento</th>
        <th>Monto</th>
        <th>Documento Referencia</th>
        <th>Fecha Pago</th>
        <th>Acciones</th>
      </tr>
    </thead>
@stop
@if (session('rank')=='Admin')
  @section('modalAgregar') "modalAgregarPago" @stop
  @section('textoAgregar')
      Pago
  @stop
  @section('formAdd')
    <!-- Documento -->
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
       <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
            <div class="input-group-prepend d-md-inline-flex">
            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
            </div>
            <select id="nuevoIdPropiedad" name="newPropertyId" class="form-control" required>
              <option value="">Seleccione apartamento</option>
            </select>
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
          
          <input class="form-control" type="text" name="newPaymentDate" id="nuevoFechaPago" placeholder="Fecha de pago" data-inputmask="'alias':'yyyy/mm/dd'" data-mask required>
          </div>
       </div>
      <!--Documento referencia-->
        <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
        </div>
        
        <input class="form-control" type="text" name="newRefDocument" placeholder="Ingresar documento de referencia" id="nuevoDocumentoReferencia" required>
      </div>
         </div>
       </div>
    <!-- Cantidad -->
    <div class="row">
    <div class="form-group ml-3" style="width: 93%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
        </div>
        
        <input class="form-control" type="number" name="newAmount" placeholder="Ingrese monto del pago" id="nuevoMonto" required>
      </div>
      
    </div>
    </div>
  @stop
  @section('nameNew') "newPayment" @stop
  @section('textoAgregar2')
      Pago
  @stop
  @section('modalEditar') "modalEditarPago" @stop
  @section('actionEditar') "pagos/editar" @stop
  @section('textoEditar')
      Pago
  @stop
  @section('formEdit')
    <!-- Documento -->
    <div class="row">
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
            <div class="input-group-prepend d-md-inline-flex">
            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
            </div>
            <select id="editIdOrganizacion" name="newOrganizationId" class="form-control" required>
              <option value="">Seleccione unidad</option>
              @foreach($unidades as $key => $unidad)
                <option value="{{$unidad->id}}">{{$unidad->name}}</option>
              @endforeach
            </select>
          <input type="hidden" name="editId" id="editId" required>
          </div>
       </div>
       <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
            <div class="input-group-prepend d-md-inline-flex">
            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
            </div>
            <select id="editIdPropiedad" name="newPropertyId" class="form-control" required>
              <option value="">Seleccione apartamento</option>
            </select>
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
          
          <input class="form-control" type="text" name="newPaymentDate" id="editFechaPago" placeholder="Fecha de pago" data-inputmask="'alias':'yyyy/mm/dd'" data-mask required>
          </div>
       </div>
      <!--Documento referencia-->
        <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
        </div>
        
        <input class="form-control" type="text" name="newRefDocument" placeholder="Ingresar documento de referencia" id="editDocumentoReferencia" required>
      </div>
         </div>
       </div>
    <!-- Cantidad -->
    <div class="row">
    <div class="form-group ml-3" style="width: 93%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
        </div>
        
        <input class="form-control" type="number" name="newAmount" placeholder="Ingrese monto del pago" id="editMonto" required>
      </div>
      
    </div>
    </div>
  @stop
  @section('nameEdit') "editPayment" @stop
  @section('textoEditar2')
      Pago
  @stop
  @section('moreForms')
    <!--=====================================
    =          Ventana Modal Edit         =
    ======================================-->
  <!-- The Modal -->
  <div class="modal" id="modalSubirPagos">

      <div class="modal-dialog">

        <div class="modal-content">
            <form role="form" method="post" action="pagos/subir" enctype="multipart/form-data">
              @csrf
              <!-- Modal Header -->
              <div class="modal-header" style="background: #E75300 ; color: white">

                <h4 class="modal-title">Subir Pagos</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <div class="box-body">
                  <!-- foto -->
                  <div class="form-group">
                    <div class="panel">SUBIR PAGOS</div>
                    <input type="file" class="pagos" name="pagos">
                    <p class="help-block">Ingrese el formato .CSV generado a partir de la plantilla de Excel</p>
                    
                  </div>
                </div>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

                <button type="submit" class="btn btn-success" name="newPayments">Subir Pagos</button>
              </div>
          </form>

        </div>
      </div>
    </div>
    <!--=====================================
    =          Ventana Modal Edit         =
    ======================================-->
  <!-- The Modal -->
  <div class="modal" id="modalPagosAnteriores">

      <div class="modal-dialog">

        <div class="modal-content">
            <form role="form" method="post" action="pagos/antiguos/subir" enctype="multipart/form-data">
              @csrf
              <!-- Modal Header -->
              <div class="modal-header" style="background: #E75300 ; color: white">

                <h4 class="modal-title">Subir Pagos Antiguos</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <div class="box-body">
                  <!-- foto -->
                  <div class="form-group">
                    <div class="panel">SUBIR PAGOS ANTIGUOS</div>
                    <input type="file" class="pagos" name="pagos">
                    <p class="help-block">Ingrese el formato .CSV generado a partir de la plantilla de Excel</p>
                    
                  </div>
                </div>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

                <button type="submit" class="btn btn-success" name="newPayments">Subir Pagos Antiguos</button>
              </div>
          </form>

        </div>
      </div>
    </div>
  @stop
@endif