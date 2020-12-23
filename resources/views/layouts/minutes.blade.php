@extends('base_table')
	@section('title')
		Minutas
	@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/minutas.js"></script>
@stop
@section('h1')
	Lista de Minutas
@stop
@section('small')
	Minutas
@stop
@section('texto1')
	Minutas
@stop
@section('cardHeader')
  @if (session('rank')=='Vigilante')
    <button class="btn btn-secondary pull-left" data-toggle="modal" data-target="#modalAgregarMinuta"> Agregar Minuta </button>
  @endif
@stop
@section('nombreTabla') tablaMinutas @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Unidad</th>
        <th>Tipo</th>
        <th>Observaciones</th>
        <th>Evidencia</th>
        <th>Fecha</th>
        <th>Reporta</th>
        <th>Acciones</th>
      </tr>
    </thead>
@stop
@if (session('rank')=='Vigilante')
  @section('modalAgregar') "modalAgregarMinuta" @stop
  @section('textoAgregar')
      Minuta
  @stop
  @section('formAdd')
    <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
          </div>
          <select id="nuevoTipoMinuta" name="newType" class="form-control" required>
            <option value="">Tipo de minuta</option>
            <option value="Recepcion">Recepcion</option>
            <option value="Entrega">Entrega</option>
            <option value="Reporte">Reporte</option>
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
      <textarea class="form-control" name="newObservations" placeholder="Anote los detalles, el reporte respectivo y detallado o lo correspondiente a recepcion o entrega con los respectivos pendientes." id="nuevoObservaciones" rows="5" required></textarea>
    </div>
  </div>
</div>
   <div class="row">
    <!-- foto -->
    <div class="form-group ml-3" style="width: 93%" title="Se debe subir la fotografia o evidencia del reporte, o el documento correspondiente segun la minuta. Se acepta formatos jpg, png o pdf con un peso inferior a 2 MB.">
      <div class="panel">SUBIR DOCUMENTO</div>
      <input type="file" class="document" name="document">
      <p class="help-block">Debe ser en formato PDF, JPG o PNG y con un peso máximo de 2MB</p>
    </div>
  </div>
  @stop
  @section('nameNew') "newMinute" @stop
  @section('textoAgregar2')
      Minuta
  @stop
@endif