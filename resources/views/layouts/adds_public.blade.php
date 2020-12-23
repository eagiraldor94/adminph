@extends('base_layout')
@section('title')
	Clasificados
@stop
@section('js')
  <!-- Personalizado -->
  <script src="/Views/js/clasificados.js"></script>
@stop
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Lista de anuncios
                <small>/ Clasificados</small></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                <li class="breadcrumb-item active">Clasificados</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <section class="content">
<!-- Default box -->
      <div class="card text-center">
        <div class="card-body">
          <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalAgregarClasificado"> Agregar Clasificado </button>
        </div>
      </div>
      <!-- /.card -->
        <div class="container-fluid py-3 row ">
          @if ($clasificados != null && $clasificados !="")
            @foreach ($clasificados as $clasificado)
              <div class="col-lg-3 pt-3 col-12 col-md-4 text-center">
                <div class="card mx-auto" style="width: 18rem;">
                <img class="card-img-top" src="/{{$clasificado->photo}}" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">{{$clasificado->subject}}</h5>
                  <p class="card-text" style="overflow:hidden;">{{$clasificado->body}}</p>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><b>Reponsable: </b>{{$clasificado->name}}</li>
                  <li class="list-group-item"><b>Teléfono: </b>{{$clasificado->phone}}</li>
                  <li class="list-group-item"><b>Email: </b>{{$clasificado->email}}</li>
                </ul>
                <div class="card-body text-center">
                  <button class='btn btn-primary btnVerClasificado' idClasificado="{{$clasificado->id}}" data-toggle='modal' data-target='#modalVerClasificado'>Ver más</button>
                </div>
              </div>
               </div>
            @endforeach
          @endif
        </div>
        <div class="row py-5 w-100 justify-content-center">
      <nav aria-label="pagination">
      <ul class="pagination justify-content-center">
        <li class="page-item @if ($prev==null) disabled @else cambioPagina @endif">
          <a class="page-link" href="clasificados/{{$prev}}">Anterior</a>
        </li>
        @if ($countersHigh!=null)
          @foreach ($countersHigh as $counter)
            <li class="page-item"><a class="page-link cambioPagina" href="clasificados/{{$counter}}">{{$counter}}</a></li>
          @endforeach
        @endif
        <li class="page-item active">
          <a class="page-link" href="#">{{$number}}</a>
        </li>
        @if ($countersLow!=null) 
          @foreach ($countersLow as $counter)
            <li class="page-item"><a class="page-link cambioPagina" href="clasificados/{{$counter}}">{{$counter}}</a></li>
          @endforeach
        @endif
        <li class="page-item @if ($next==null) disabled @else cambioPagina @endif">
          <a class="page-link" href="clasificados/{{$next}}">Siguiente</a>
        </li>
      </ul>
    </nav>
     </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <!--=====================================
    =          Ventana Modal Add         =
    ======================================-->
  <!-- The Modal -->
  <div class="modal" id="modalAgregarClasificado">

    <div class="modal-dialog">

      <div class="modal-content">
          <form role="form" method="post" enctype="multipart/form-data">
          @csrf
            <!-- Modal Header -->
            <div class="modal-header" style="background: #E75300 ; color: white">

              <h4 class="modal-title">Agregar Clasificado</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="box-body">
                    <!-- Asunto -->
                    <div class="row">
                      <div class="form-group ml-3" style="width:93%">
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        </div>
                        <input class="form-control" type="text" placeholder="Asunto" name="newSubject" required>
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
                        <textarea class="form-control" name="newBody" placeholder="Cuerpo del Anuncio" rows="6" required></textarea>
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
                          <input class="form-control" type="text" placeholder="Teléfono" name="newPhone" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
                        </div>
                     </div>
                    <div class="form-group ml-3" style="width:45%">
                      <div class="input-group mb-3">
                          <div class="input-group-prepend d-md-inline-flex">
                          <span class="input-group-text">@</span>
                          </div>
                          <input class="form-control" type="email" name="newEmail" placeholder="Email" required>
                        </div>
                     </div>
                   </div>
                   <div class="row">
                    <!-- foto -->
                    <div class="form-group ml-3" style="width: 93%" title="Se debe subir la fotografia principal. Se acepta formatos jpg o png con un peso inferior a 2 MB. La imagen se redimensionará a un formato 4 x 3, por esta razón debe ir en este formato para que no se afecte su visualización.">
                      <div class="panel">SUBIR FOTO</div>
                      <input type="file" class="photo" name="photo">
                      <p class="help-block">Debe ser en formato JPG o PNG y con un peso máximo de 2MB. Formato 4 x 3</p>
                    </div>
                  </div>
                   <div class="row">
                    <!-- documento -->
                    <div class="form-group ml-3" style="width: 93%" title="Se debe subir un documento que profundice en el anuncio. Se acepta formatos jpg, png o pdf con un peso inferior a 2 MB.">
                      <div class="panel">SUBIR DOCUMENTO</div>
                      <input type="file" class="document" name="document">
                      <p class="help-block">Debe ser en formato PDF, JPG o PNG y con un peso máximo de 2MB</p>
                    </div>
                  </div>
              </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

              <button type="submit" class="btn btn-success" name="newAdd">Guardar Clasificado</button>
            </div>
        </form>

      </div>
    </div>
  </div>
    <!--=====================================
      =          Ventana Modal Ver         =
      ======================================-->
    <!-- The Modal -->
    <div class="modal" id="modalVerClasificado">

      <div class="modal-dialog">

        <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header" style="background: #E75300 ; color: white">

                <h4 class="modal-title">Clasificado</h4>
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
                        <textarea class="form-control" name="newBody" placeholder="Cuerpo del Anuncio" id="verCuerpo" rows="6" readonly></textarea>
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
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
              </div>
        </div>
      </div>
    </div>
@stop