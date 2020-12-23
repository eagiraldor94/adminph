@extends('base_table')
	@section('title')
		Control de correspondencia
	@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/correspondencia.js"></script>
@stop
@section('h1')
	Lista de correspondencia
@stop
@section('small')
	Correspondencia
@stop
@section('texto1')
	Correspondencia
@stop
@section('cardHeader')
  @if (session('rank')=='Vigilante')
    <button class="btn btn-secondary pull-left" data-toggle="modal" data-target="#modalAgregarCorrespondencia"> Agregar Correspondencia </button>
  @endif
@stop
@section('nombreTabla') tablaCorrespondencia @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Unidad</th>
        <th>Apartamento</th>
        <th>Foto</th>
        <th>Destinatario</th>
        <th>Tipo doc</th>
        <th>Documento</th>
        <th>Recibe</th>
        <th>Reclama</th>
        <th>Tipo doc</th>
        <th>Documento</th>
        <th>Entrega</th>
        <th>Fecha entrega</th>
        <th>Observaciones</th>
        <th>Creado</th>
        <th>Editado</th>
        <th>Acciones</th>
      </tr>
    </thead>
@stop
@if (session('rank')=='Vigilante')
  @section('modalAgregar') "modalAgregarCorrespondencia" @stop
  @section('textoAgregar')
      Correspondencia
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
      <!--nombre -->
      <div class="row">
       <div class="form-group ml-3" style="width: 93%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-user"></i></span>
        </div>
        <input class="form-control" type="text" id="nuevoNombre" name="newName" placeholder="Nombre del destinatario" required>
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
    <!-- Descripcion -->
  <div class="form-group ml-3" style="width: 93%">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
      </div>
      <textarea class="form-control" name="newObservations" placeholder="Observaciones" id="nuevoObservaciones" rows="3" required></textarea>
    </div>
  </div>
</div>
<div class="row">
  <!-- foto -->
  <div class="form-group ml-3" style="width: 93%">
    <div class="panel">SUBIR FOTOGRAFÍA</div>
    <input type="file" class="photo" name="photo" id="nuevoFoto">
    <p class="help-block">Suba la fotografía del pquete en formato jpg o png con un peso inferior a 2MB (opcional)</p>
  </div>
</div>
  @stop
  @section('nameNew') "newPackage" @stop
  @section('textoAgregar2')
      Correspondencia
  @stop
@endif
@if (session('rank')=='Vigilante')
  @section('moreForms')
    <!--=====================================
    =          Ventana Modal Edit         =
    ======================================-->
  <!-- The Modal -->
  <div class="modal" id="modalEntregarCorrespondencia">

      <div class="modal-dialog">

        <div class="modal-content">
            <form role="form" method="post" action="correspondencia/entrega" enctype="multipart/form-data">
              @csrf
              <!-- Modal Header -->
              <div class="modal-header" style="background: #E75300 ; color: white">
                <h4 class="modal-title">Entrega de correspondencia</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <!-- Modal body -->
              <div class="modal-body">
                <div class="box-body">
                  <!--nombre -->
                  <div class="row">
                   <div class="form-group ml-3" style="width: 93%">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <input type="hidden" name="newAuthId" id="nuevoIdAutorizacion">
                    <input class="form-control" type="text" id="nuevoNombreReclama" name="newName" placeholder="Nombre de quien reclama" required>
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
                      <select id="nuevoTipoDocumentoReclama" name="newClaimerIdType" class="form-control" required>
                        <option value="">Tipo de documento</option>
                        <option value="CC">Cedula de ciudadanía</option>
                        <option value="CE">Cedula de extrajería</option>
                      </select>
                    </div>
                 </div>
                 <div class="form-group ml-3" style="width:60%">
                  <div class="input-group mb-3">
                      <div class="input-group-prepend d-md-inline-flex">
                      <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                      </div>
                      <input type="text" class="form-control" name="newClaimerIdNumber" id="nuevoNumeroDocumentoReclama" placeholder="Número del documento" required>
                    </div>
                 </div>
               </div>
                </div>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
                <button type="submit" class="btn btn-success" name="newAuth">Autorizar entrega</button>
              </div>
          </form>

        </div>
      </div>
    </div>
  @stop
@endif