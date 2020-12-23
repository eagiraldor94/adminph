@extends('base_layout')
@section('title')
	Parámetros
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/parametros.js"></script>
@stop
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
<!-- Default box -->
      <div class="card mb-5 pb-5 text-center">
        <div class="card-header bg-secondary mb-3 p-4">
          <h1 class="card-title">Parametros del sistema</h1>

        </div>
        <div class="card-body">
          @foreach($parametros as $key => $parametro)
          @if ($parametro->name == "Firma Digital")
          <form role="form" method="post" enctype="multipart/form-data">
            <div class="row">
              @csrf
              <!-- foto -->
              <div class="form-group mx-3" style="width:100%">
                <div class="panel pb-3"><b>SUBIR FIRMA</b></div>
                <input type="file" class="sign pb-3" name="sign" id="nuevoFirma">
                <p class="help-block">Suba la firma digital del adminitrador en formato JPG o PNG con un peso inferior a 2MB. Debe estar en una proporcion 2.4 a 1, por ejemplo 178px de ancho por 75px de alto.</p>
              </div>
            </div>
            <div class="row w-100 justify-content-center">
              <button type="submit" class="btn btn-success" name="newSign">Actualizar Firma</button>
            </div>
          </form>
          @else
            <div class="row">
              <div class="form-group mx-3" style="width:100%">
                <div class="input-group mb-3">
                    <div class="input-group-prepend d-md-inline-flex">
                    <span class="input-group-text">{{$parametro->name}}</span>
                    </div>
                    <input type="text" class="form-control" name="newValue" id="{{$parametro->id}}" placeholder="{{$parametro->name}}" value="{{$parametro->value}}" required>
                    <div class="input-group-append d-md-inline-flex">
                    <button class="input-group-text btnUpdate btn btn-primary" idParametro="{{$parametro->id}}" idCampo="#{{$parametro->id}}">Actualizar</button>
                    </div>
                  </div>
              </div>
            </div>
          @endif
          @endforeach
        </div>
        <!-- /.card-body -->

      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@stop