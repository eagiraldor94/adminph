@extends('base_table')
	@section('title')
		Autorización de visitantes
	@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/visitantes.js"></script>
@stop
@section('h1')
	Lista de Visitantes
@stop
@section('small')
	Visitantes
@stop
@section('texto1')
	Visitantes
@stop
@section('cardHeader')
  @if (session('rank')!='Admin' && session('rank')!='Vigilante' && session('rank')!='Concejo')
    <button class="btn btn-secondary pull-left" data-toggle="modal" data-target="#modalAgregarVisitante"> Agregar Visitante </button>
  @endif
@stop
@section('nombreTabla') tablaVisitantes @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Unidad</th>
        <th>Apartamento</th>
        <th>Autorizado</th>
        <th>Tipo doc</th>
        <th>Documento</th>
        <th>Fecha</th>
        <th>Hora inicio</th>
        <th>Hora fin</th>
        <th>Autoriza</th>
        <th>Da ingreso</th>
        <th>Observaciones</th>
        <th>Acciones</th>
      </tr>
    </thead>
@stop
@if (session('rank')!='Admin' && session('rank')!='Vigilante' && session('rank')!='Concejo')
  @section('modalAgregar') "modalAgregarVisitante" @stop
  @section('textoAgregar')
      Visitante
  @stop
  @section('formAdd')
      <!-- Fecha y nombre -->
      <div class="row">
        <div class="form-group ml-3" style="width:45%">
          <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
          </div>
          <input class="form-control datepicker" type="text" name="newVisitDate" id="nuevoFechaVisita" placeholder="Fecha de la visita" data-inputmask="'alias':'dd/mm/yyyy'" data-mask required>
          </div>
       </div>
       <div class="form-group ml-3" style="width: 45%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-user"></i></span>
        </div>
        <input class="form-control" type="text" id="nuevoNombre" name="newName" placeholder="Nombre completo del visitante" title="Si es una visita tecnica especificar compañia y detalles en observaciones" required>
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
      <!-- horas -->
      <div class="row">
        <div class="form-group ml-3" style="width:45%">
          <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-hourglass-start"></i></span>
          </div>
          <input class="form-control timepicker" type="text" name="newStartHour" id="nuevoHoraInicial" placeholder="Hora de autorización de la visita" required>
          </div>
       </div>
        <div class="form-group ml-3" style="width:45%">
          <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-hourglass-end"></i></span>
          </div>
          <input class="form-control timepicker" type="text" name="newEndHour" id="nuevoHoraFinal" placeholder="Hora maxima de ingreso" required>
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
  @stop
  @section('nameNew') "newGuest" @stop
  @section('textoAgregar2')
      Visitante
  @stop
@endif
@if (session('rank')=='Vigilante')
  @section('moreForms')
    <!--=====================================
    =          Ventana Modal Edit         =
    ======================================-->
  <!-- The Modal -->
  <div class="modal" id="modalAutorizarIngreso">

      <div class="modal-dialog">

        <div class="modal-content">
            <form role="form" method="post" action="visitantes/autorizar" enctype="multipart/form-data">
              @csrf
              <!-- Modal Header -->
              <div class="modal-header" style="background: #E75300 ; color: white">
                <h4 class="modal-title">Autorizar ingreso</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <!-- Modal body -->
              <div class="modal-body">
                <div class="box-body">
                  <!-- foto -->
                  <div class="form-group">
                    <input type="hidden" name="newAuthId" id="nuevoIdAutorizacion">
                    <div class="panel">SUBIR FOTOGRAFÍA</div>
                    <input type="file" class="photo" name="photo" id="nuevoFotoVisitante">
                    <p class="help-block">Suba la fotografía del visitante en formato jpg o png con un peso inferior a 2MB (opcional)</p>
                  </div>
                  <!-- foto -->
                  <div class="form-group">
                    <div class="panel">SUBIR DOCUMENTO</div>
                    <input type="file" class="document" name="document" id="nuevoDocumentoVisitante">
                    <p class="help-block">Suba el escaneo del documento de identidad del visitante en formato PDF con un peso inferior a 2MB (opcional)</p>
                  </div>
                </div>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
                <button type="submit" class="btn btn-success" name="newAuth">Autorizar ingreso</button>
              </div>
          </form>

        </div>
      </div>
    </div>
  @stop
@endif