@extends('base_table')
	@section('title')
		Reportes
	@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="/Views/js/reportes-daños.js"></script>
@stop
@section('h1')
	Lista de Reportes
@stop
@section('small')
	Reportes
@stop
@section('texto1')
	Reportes
@stop
@section('cardHeader')
  @if (session('rank')=='Arrendatario' || session('rank')=='Encargado' || session('rank')=='Propietario')
    <button class="btn btn-secondary pull-left" data-toggle="modal" data-target="#modalAgregarReporte"> Agregar Reporte </button>
  @endif
@stop
@section('nombreTabla') tablaReportes @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Unidad</th>
        <th>Apartamento</th>
        <th>Prioridad</th>
        <th>Observaciones</th>
        <th>Evidencia</th>
        <th>Fecha</th>
        <th>Reporta</th>
        <th>Acciones</th>
      </tr>
    </thead>
@stop
@if (session('rank')=='Arrendatario' || session('rank')=='Encargado' || session('rank')=='Propietario')
  @section('modalAgregar') "modalAgregarReporte" @stop
  @section('textoAgregar')
      Reporte
  @stop
  @section('formAdd')
    <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
          </div>
          <select id="nuevoPrioridad" name="newPriority" class="form-control" required>
            <option value="">Prioridad</option>
            <option value="Alta">Alta</option>
            <option value="Media">Media</option>
            <option value="Baja">Baja</option>
          </select>
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
      <textarea class="form-control" name="newObservations" placeholder="Anote los detalles del reporte de daño detallado." id="nuevoObservaciones" rows="5" required></textarea>
    </div>
  </div>
</div>
   <div class="row">
    <!-- foto -->
    <div class="form-group ml-3" style="width: 93%" title="Se debe subir la fotografia, documento o evidencia del reporte. Se acepta formatos jpg, png o pdf con un peso inferior a 2 MB.">
      <div class="panel">SUBIR DOCUMENTO</div>
      <input type="file" class="document" name="document">
      <p class="help-block">Debe ser en formato PDF, JPG o PNG y con un peso máximo de 2MB</p>
    </div>
  </div>
  @stop
  @section('nameNew') "newReport" @stop
  @section('textoAgregar2')
      Reporte
  @stop
@endif
@if (session('rank')=='Admin')
  @section('moreForms')
    <!--=====================================
    =          Ventana Modal Edit         =
    ======================================-->
  <!-- The Modal -->
  <div class="modal" id="modalCambiarPrioridad">

      <div class="modal-dialog">

        <div class="modal-content">
            <form role="form" method="post" action="reportes/priorizar" enctype="multipart/form-data">
              @csrf
              <!-- Modal Header -->
              <div class="modal-header" style="background: #E75300 ; color: white">
                <h4 class="modal-title">Cambiar Prioridad</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <!-- Modal body -->
              <div class="modal-body">
                <div class="box-body">
                  <div class="row">
                  <div class="form-group ml-3" style="width:93%">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend d-md-inline-flex">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="hidden" name="newAuthId" id="nuevoIdAutorizacion">
                        <select id="nuevoPrioridad" name="newPriorityChange" class="form-control" required>
                          <option value="">Prioridad</option>
                          <option value="Alta">Alta</option>
                          <option value="Media">Media</option>
                          <option value="Baja">Baja</option>
                        </select>
                      </div>
                   </div>
                   </div>
                </div>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
                <button type="submit" class="btn btn-success" name="newPriority">Cambiar Prioridad</button>
              </div>
          </form>

        </div>
      </div>
    </div>
  @stop
@endif