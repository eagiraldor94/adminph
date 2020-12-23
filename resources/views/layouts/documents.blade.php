@extends('base_table')
	@section('title')
		Documentos
	@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/documentos.js"></script>
@stop
@section('h1')
	Lista de Documentos
@stop
@section('small')
	Documentos
@stop
@section('texto1')
	Documentos
@stop
@if (session('rank')=='Admin')
  @section('cardHeader')
      <button class="btn btn-secondary pull-left" data-toggle="modal" data-target="#modalAgregarDocumento"> Agregar Documento </button>
      <div class="form-group form-inline pull-right">
        <button class="btn btn-primary2 mr-2" data-toggle="modal" data-target="#modalSubirDocumentos"> Subir Documentos </button>
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalDocumentosAnteriores"> Subir Documentos Antiguos </button>
      </div>
  @stop
@endif
@section('nombreTabla') tablaDocumentos @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Número</th>
        <th>Concepto</th>
        <th>Unidad</th>
        <th>Apartamento</th>
        <th>Fecha</th>
        <th>Monto</th>
        <th>Acciones</th>
      </tr>
    </thead>
@stop
@if (session('rank')=='Admin')
  @section('modalAgregar') "modalAgregarDocumento" @stop
  @section('textoAgregar')
      Documento
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
            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
          </div>
          
          <input class="form-control" type="number" name="newAmount" placeholder="Ingrese monto del pago" id="nuevoMonto" required>
        </div>
       </div>
      <!--Documento referencia-->
        <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
            <div class="input-group-prepend d-md-inline-flex">
            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
            </div>
            <select id="nuevoIdConcepto" name="newConceptId" class="form-control" required>
              <option value="">Seleccione concepto</option>
              @foreach($conceptos as $key => $concepto)
                <option value="{{$concepto->id}}">{{$concepto->name}}</option>
              @endforeach
            </select>
          </div>
         </div>
       </div>
    <!-- Cantidad -->
    <div class="row">
    <div class="form-group ml-3" style="width: 93%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
        </div>
        <textarea class="form-control" name="newBody" placeholder="Ingrese el detalle" id="nuevoCuerpo" rows="4"></textarea>
      </div>
      
    </div>
    </div>
  @stop
  @section('nameNew') "newDocument" @stop
  @section('textoAgregar2')
      Documento
  @stop
  @section('modalEditar') "modalEditarDocumento" @stop
  @section('actionEditar') "documentos/editar" @stop
  @section('textoEditar')
      Documento
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
      <!-- Monto -->
      <div class="row">
        <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
          </div>
          
          <input class="form-control" type="number" name="newAmount" placeholder="Ingrese monto del pago" id="editMonto" required>
        </div>
       </div>
      <!--Documento referencia-->
        <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
            <div class="input-group-prepend d-md-inline-flex">
            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
            </div>
            <select id="editIdConcepto" name="newConceptId" class="form-control" required>
              <option value="">Seleccione concepto</option>
              @foreach($conceptos as $key => $concepto)
                <option value="{{$concepto->id}}">{{$concepto->name}}</option>
              @endforeach
            </select>
          </div>
         </div>
       </div>
    <!-- Cantidad -->
    <div class="row">
    <div class="form-group ml-3" style="width: 93%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
        </div>
        <textarea class="form-control" name="newBody" placeholder="Ingrese el detalle" id="editCuerpo" rows="4"></textarea>
      </div>
      
    </div>
    </div>
  @stop
  @section('nameEdit') "editDocument" @stop
  @section('textoEditar2')
      Documento
  @stop
  @section('moreForms')
    <!--=====================================
    =          Ventana Modal Edit         =
    ======================================-->
  <!-- The Modal -->
  <div class="modal" id="modalSubirDocumentos">

      <div class="modal-dialog">

        <div class="modal-content">
            <form role="form" method="post" action="documentos/subir" enctype="multipart/form-data">
              @csrf
              <!-- Modal Header -->
              <div class="modal-header" style="background: #E75300 ; color: white">

                <h4 class="modal-title">Subir Documentos</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <div class="box-body">
                  <!-- foto -->
                  <div class="form-group">
                    <div class="panel">Subir Documentos</div>
                    <input type="file" class="documentos" name="documentos">
                    <p class="help-block">Ingrese el formato .CSV generado a partir de la plantilla de Excel</p>
                    
                  </div>
                </div>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

                <button type="submit" class="btn btn-success" name="newDocuments">Subir Documentos</button>
              </div>
          </form>

        </div>
      </div>
    </div>
    <!--=====================================
    =          Ventana Modal Edit         =
    ======================================-->
  <!-- The Modal -->
  <div class="modal" id="modalDocumentosAnteriores">

      <div class="modal-dialog">

        <div class="modal-content">
            <form role="form" method="post" action="documentos/antiguos/subir" enctype="multipart/form-data">
              @csrf
              <!-- Modal Header -->
              <div class="modal-header" style="background: #E75300 ; color: white">

                <h4 class="modal-title">Subir Documentos Antiguos</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <div class="box-body">
                  <!-- foto -->
                  <div class="form-group">
                    <div class="panel">Subir Documentos Antiguos</div>
                    <input type="file" class="documentos" name="documentos">
                    <p class="help-block">Ingrese el formato .CSV generado a partir de la plantilla de Excel</p>
                    
                  </div>
                </div>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

                <button type="submit" class="btn btn-success" name="newDocuments">Subir Documentos Antiguos</button>
              </div>
          </form>

        </div>
      </div>
    </div>
  @stop
@endif