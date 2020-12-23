@extends('base_table')
@section('title')
	Boletines
@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/boletines.js"></script>
@stop
@section('h1')
	Lista de Boletines
@stop
@section('small')
	Boletines
@stop
@section('texto1')
	Boletines
@stop
@section('cardHeader')
  @if (session('rank')=='Admin')
      <button class="btn btn-secondary" data-toggle="modal" data-target="#modalAgregarBoletin"> Agregar Boletin </button>
  @endif
@stop
@section('nombreTabla') tablaBoletines @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Unidad</th>
        <th>Asunto</th>
        <th>Documento</th>
        <th>Acciones</th>
      </tr>
    </thead>
@stop
@if (session('rank')=='Admin')
  @section('modalAgregar') "modalAgregarBoletin" @stop
  @section('textoAgregar')
      Boletin
  @stop
  @section('formAdd')
    <!-- Documento -->
    <div class="row">
      <div class="form-group ml-3" style="width:93%">
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
     </div>
      <!-- Asunto -->
      <div class="row">
        <div class="form-group ml-3" style="width:93%">
          <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
          </div>
          
          <input class="form-control" type="text" name="newSubject" id="nuevoAsunto" placeholder="Asunto" required>
        </div>
         </div>
      </div>
    <div class="row">
      <!-- Placas -->
    <div class="form-group ml-3" style="width: 93%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
        </div>
        <textarea class="form-control" name="newBody" placeholder="Ingrese el cuerpo del boletin" id="nuevoCuerpo" rows="6"></textarea>
      </div>
    </div>
  </div>
    <!-- foto -->
    <div class="row">
    <div class="form-group ml-3" style="width: 93%">
      <div class="panel">SUBIR PDF</div>
      <input type="file" class="document" name="document">
      <p class="help-block">Peso máximo del documento 5MB</p>
    </div>
  </div>
  @stop
  @section('nameNew') "newBulletin" @stop
  @section('textoAgregar2')
      Boletin
  @stop
  @section('modalEditar') "modalEditarBoletin" @stop
  @section('actionEditar') "boletines/editar" @stop
  @section('textoEditar')
      Boletin
  @stop
  @section('formEdit')
    <!-- Documento -->
    <div class="row">
      <div class="form-group ml-3" style="width:93%">
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
     </div>
      <!-- Asunto -->
      <div class="row">
        <div class="form-group ml-3" style="width:93%">
          <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
          </div>
          
          <input class="form-control" type="text" name="newSubject" id="editAsunto" placeholder="Asunto" required>
        </div>
         </div>
      </div>
    <div class="row">
      <!-- Placas -->
    <div class="form-group ml-3" style="width: 93%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
        </div>
        <textarea class="form-control" name="newBody" placeholder="Ingrese el cuerpo del boletin" id="editCuerpo" rows="6"></textarea>
      </div>
    </div>
  </div>
    <!-- foto -->
    <div class="row">
    <div class="form-group ml-3" style="width: 93%">
      <div class="panel">SUBIR PDF</div>
      <input type="file" class="document" name="document">
      <input type="hidden" name="lastDocument" id="lastDocument">
      <p class="help-block">Peso máximo del documento 5MB</p>
    </div>
  </div>
  @stop
  @section('nameEdit') "editBulletin" @stop
  @section('textoEditar2')
      Boletin
  @stop
@endif
@section('moreForms')
  <!--=====================================
    =          Ventana Modal Edit         =
    ======================================-->
  <!-- The Modal -->
  <div class="modal" id="modalVerBoletin">

    <div class="modal-dialog">

      <div class="modal-content">
          <form role="form">
            <!-- Modal Header -->
            <div class="modal-header" style="background: #E75300 ; color: white">

              <h4 class="modal-title">Boletin</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="box-body">
                <!-- Documento -->
                <div class="row">
                  <div class="form-group ml-3" style="width:93%">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend d-md-inline-flex">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input class="form-control" type="text" id="verOrganizacion" placeholder="Unidad" readonly>
                      </div>
                   </div>
                 </div>
                  <!-- Asunto -->
                  <div class="row">
                    <div class="form-group ml-3" style="width:93%">
                      <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                      </div>
                      <input class="form-control" type="text" id="verAsunto" placeholder="Asunto" readonly>
                    </div>
                     </div>
                  </div>
                  <div class="row">
                    <!-- Cuerpos -->
                  <div class="form-group ml-3" style="width: 93%">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                      </div>
                      <textarea class="form-control" name="newBody" placeholder="Cuerpo del boletin" id="verCuerpo" rows="6" readonly></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
            </div>
        </form>

      </div>
    </div>
  </div>
@stop