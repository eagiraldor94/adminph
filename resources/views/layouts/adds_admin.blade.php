@extends('base_table')
	@section('title')
		Clasificados
	@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/clasificados-admin.js"></script>
@stop
@section('h1')
	Lista de Clasificados
@stop
@section('small')
	Clasificados
@stop
@section('texto1')
	Clasificados
@stop
@section('nombreTabla') tablaClasificados @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Foto</th>
        <th>Unidad</th>
        <th>Apartamento</th>
        <th>Asunto</th>
        <th>Telefono</th>
        <th>Email</th>
        <th>Autorizado</th>
        <th>Acciones</th>
      </tr>
    </thead>
@stop
@if (session('rank')=='Admin')
  @section('moreForms')
    <!--=====================================
      =          Ventana Modal Edit         =
      ======================================-->
    <!-- The Modal -->
    <div class="modal" id="modalAutorizarClasificado">

      <div class="modal-dialog">

        <div class="modal-content">
            <form role="form" method="post" action="/autorizar-clasificado" enctype="multipart/form-data">
              @csrf
              <!-- Modal Header -->
              <div class="modal-header" style="background: #E75300 ; color: white">
                <h4 class="modal-title">Autorizar Clasificado</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <div class="box-body">
                  <!-- Apartamento -->
                  <div class="row">
                    <div class="form-group ml-3" style="width:45%">
                      <div class="input-group mb-3">
                          <div class="input-group-prepend d-md-inline-flex">
                          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                          </div>
                          <input class="form-control" type="text" id="verOrganizacion" placeholder="Unidad" readonly>
                          <input type="hidden" id="nuevoAuthId" name="newAuthId">
                        </div>
                     </div>
                    <div class="form-group ml-3" style="width:45%">
                      <div class="input-group mb-3">
                          <div class="input-group-prepend d-md-inline-flex">
                          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                          </div>
                          <input class="form-control" type="text" id="verApartamento" placeholder="Apartamento" readonly>
                        </div>
                     </div>
                   </div>
                    <!-- Nombre -->
                    <div class="row">
                      <div class="form-group ml-3" style="width:93%">
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input class="form-control" type="text" id="verNombre" placeholder="Nombre" readonly>
                      </div>
                       </div>
                    </div>
                  <!-- Telefono y mail -->
                  <div class="row">
                    <div class="form-group ml-3" style="width:45%">
                      <div class="input-group mb-3">
                          <div class="input-group-prepend d-md-inline-flex">
                          <span class="input-group-text"><i class="fas fa-phone"></i></span>
                          </div>
                          <input class="form-control" type="text" id="verTelefono" placeholder="Teléfono" readonly>
                        </div>
                     </div>
                    <div class="form-group ml-3" style="width:45%">
                      <div class="input-group mb-3">
                          <div class="input-group-prepend d-md-inline-flex">
                          <span class="input-group-text">@</span>
                          </div>
                          <input class="form-control" type="text" id="verEmail" placeholder="Email" readonly>
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
                      <!-- Cuerpo -->
                    <div class="form-group ml-3" style="width: 93%">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                        </div>
                        <textarea class="form-control" placeholder="Cuerpo del Anuncio" id="verCuerpo" rows="6" readonly></textarea>
                      </div>
                    </div>
                  </div>
                    <div class="row">
                      <!-- Documento -->
                    <div class="form-group ml-3 w-100 d-inline-flex justify-content-center" style="width: 93%">
                      <div class="input-group mb-3 w-50">
                        <a style="color:#fff !important" class="form-control btn btn-primary" id="verDocumento" href='' target='_blank'>Ver documento</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="newAuth">Autorizar</button>
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
              </div>
          </form>

        </div>
      </div>
    </div>
  @stop
@endif