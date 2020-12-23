@extends('base_table')
	@section('title')
		Bienes
	@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/bienes.js"></script>
@stop
@section('h1')
	Lista de Bienes
@stop
@section('small')
	Bienes
@stop
@section('texto1')
	Bienes
@stop
@section('cardHeader')
    <button class="btn btn-secondary pull-left" data-toggle="modal" data-target="#modalAgregarPropiedad"> Agregar Bien </button>
    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalSubirPropiedades"> Subir Propiedades </button>
@stop
@section('nombreTabla') tablaBienes @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Unidad</th>
        <th>Apartamento</th>
        <th>Coeficiente</th>
        <th>Parqueadero</th>
        <th>Coeficiente</th>
        <th>Cuarto útil</th>
        <th>Coeficiente</th>
        <th>Cuota extra</th>
        <th>Imprimir factura</th>
        <th>Tarifa fija</th>
        <th>Acciones</th>
      </tr>
    </thead>
@stop
@section('modalAgregar') "modalAgregarPropiedad" @stop
@section('textoAgregar')
    Bien
@stop
@section('formAdd')
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-building"></i></span>
          </div>
        <select name="newOrganizationId" id="nuevoIdUnidad" class="form-control" required>
          <option value="">Seleccione la unidad</option>
          @foreach ($unidades as $key => $unidad)
          <option value="{{$unidad->id}}">{{$unidad->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <!-- Apartamento -->
  <div class="row">
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
          </div>
          <input class="form-control" type="text" id="nuevoApartamento" name="newApartment" placeholder="Apartamento" required>  
        </div>
     </div>
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-percentage"></i></span>
          </div>
          <input type="text" class="form-control" name="newApartmentCoefficient" id="nuevoCoefficienteApartamento" placeholder="Coeficiente Apartamento" required>
        </div>
     </div>
   </div>
  <!-- Parqueadero -->
  <div class="row">
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
          </div>
          <input class="form-control" type="text" id="nuevoParqueadero" name="newParking" placeholder="Parqueadero">  
        </div>
     </div>
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-percentage"></i></span>
          </div>
          <input type="text" class="form-control" name="newParkingCoefficient" id="nuevoCoefficienteParqueadero" placeholder="Coeficiente Parqueadero">
        </div>
     </div>
   </div>
  <!-- Cuarto Util -->
  <div class="row">
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
          </div>
          <input class="form-control" type="text" id="nuevoCuartoUtil" name="newUsefulRoom" placeholder="Cuarto Útil">  
        </div>
     </div>
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-percentage"></i></span>
          </div>
          <input type="text" class="form-control" name="newUsefulRoomCoefficient" id="nuevoCoefficienteCuartoUtil" placeholder="Coeficiente Cuarto Útil">
        </div>
     </div>
   </div>
  <div class="row">
    <!-- Placas -->
  <div class="form-group ml-3" style="width: 93%">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-car"></i></span>
      </div>
      <textarea class="form-control" name="newPlates" placeholder="Ingrese las placas de los vehículos" id="nuevoPlacas" rows="2"></textarea>
    </div>
  </div>
</div>
  <div class="row">
    <!-- Mascotas -->
  <div class="form-group ml-3" style="width: 93%">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-paw"></i></span>
      </div>
      <textarea class="form-control" name="newPets" placeholder="Ingrese las mascotas" id="nuevoMascotas" rows="2"></textarea>
    </div>
  </div>
</div>
  <!-- Cuota extra y factura -->
  <div class="row">
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-wallet"></i></span>
          </div>
        <select name="newExtraFeeState" id="nuevoEstadoCuotaExtra" class="form-control" required>
          <option value="">¿Tiene cuota extra?</option>
          <option value="1">Si</option>
          <option value="0">No</option>
        </select>
        </div>
     </div>
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-file-pdf"></i></span>
          </div>
        <select name="newBillState" id="nuevoEstadoFactura" class="form-control" required>
          <option value="">¿Se imprime factura?</option>
          <option value="1">Si</option>
          <option value="0">No</option>
        </select>
        </div>
     </div>
   </div>
   <div class="row">
     <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-money-bill-wave-alt"></i></span>
          </div>
          <input type="number" class="form-control" name="newFixedFee" id="nuevoCobroFijo" placeholder="Tarifa fija">
        </div>
     </div>
   </div>
@stop
@section('nameNew') "newProperty" @stop
@section('textoAgregar2')
    Bien
@stop
@section('modalEditar') "modalEditarPropiedad" @stop
@section('actionEditar') "propiedades/editar" @stop
@section('textoEditar')
    Bien
@stop
@section('formEdit')
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-building"></i></span>
          </div>
        <select name="newOrganizationId" id="editIdUnidad" class="form-control" required>
          <option value="">Seleccione la unidad</option>
          @foreach ($unidades as $key => $unidad)
          <option value="{{$unidad->id}}">{{$unidad->name}}</option>
          @endforeach
        </select>

        <input type="hidden" name="editId" id="editId" required>

        </div>
     </div>
  </div>
  <!-- Apartamento -->
  <div class="row">
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
          </div>
          <input class="form-control" type="text" id="editApartamento" name="newApartment" placeholder="Apartamento" required>  
        </div>
     </div>
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-percentage"></i></span>
          </div>
          <input type="text" class="form-control" name="newApartmentCoefficient" id="editCoefficienteApartamento" placeholder="Coeficiente Apartamento" required>
        </div>
     </div>
   </div>
  <!-- Parqueadero -->
  <div class="row">
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
          </div>
          <input class="form-control" type="text" id="editParqueadero" name="newParking" placeholder="Parqueadero">  
        </div>
     </div>
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-percentage"></i></span>
          </div>
          <input type="text" class="form-control" name="newParkingCoefficient" id="editCoefficienteParqueadero" placeholder="Coeficiente Parqueadero">
        </div>
     </div>
   </div>
  <!-- Cuarto Util -->
  <div class="row">
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
          </div>
          <input class="form-control" type="text" id="editCuartoUtil" name="newUsefulRoom" placeholder="Cuarto Útil">  
        </div>
     </div>
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-percentage"></i></span>
          </div>
          <input type="text" class="form-control" name="newUsefulRoomCoefficient" id="editCoefficienteCuartoUtil" placeholder="Coeficiente Cuarto Útil">
        </div>
     </div>
   </div>
  <div class="row">
    <!-- Placas -->
  <div class="form-group ml-3" style="width: 93%">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-car"></i></span>
      </div>
      <textarea class="form-control" name="newPlates" placeholder="Ingrese las placas de los vehículos" id="editPlacas" rows="2"></textarea>
    </div>
  </div>
</div>
  <div class="row">
    <!-- Mascotas -->
  <div class="form-group ml-3" style="width: 93%">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-paw"></i></span>
      </div>
      <textarea class="form-control" name="newPets" placeholder="Ingrese las mascotas" id="editMascotas" rows="2"></textarea>
    </div>
  </div>
</div>
  <!-- Cuota extra y factura -->
  <div class="row">
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-wallet"></i></span>
          </div>
        <select name="newExtraFeeState" id="editEstadoCuotaExtra" class="form-control" required>
          <option value="">¿Tiene cuota extra?</option>
          <option value="1">Si</option>
          <option value="0">No</option>
        </select>
        </div>
     </div>
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-file-pdf"></i></span>
          </div>
        <select name="newBillState" id="editEstadoFactura" class="form-control" required>
          <option value="">¿Se imprime factura?</option>
          <option value="1">Si</option>
          <option value="0">No</option>
        </select>
        </div>
     </div>
   </div>
   <div class="row">
     <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-money-bill-wave-alt"></i></span>
          </div>
          <input type="number" class="form-control" name="newFixedFee" id="editCobroFijo" placeholder="Tarifa fija">
        </div>
     </div>
   </div>
@stop
@section('nameEdit') "editProperty" @stop
@section('textoEditar2')
    Bien
@stop
@section('moreForms')
  <!--=====================================
  =          Ventana Modal Edit         =
  ======================================-->
<!-- The Modal -->
<div class="modal" id="modalSubirPropiedades">

    <div class="modal-dialog">

      <div class="modal-content">
          <form role="form" method="post" action="propiedades/subir" enctype="multipart/form-data">
            @csrf
            <!-- Modal Header -->
            <div class="modal-header" style="background: #E75300 ; color: white">

              <h4 class="modal-title">Subir Propiedades</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="box-body">
                <!-- foto -->
                <div class="form-group">
                  <div class="panel">Subir Propiedades</div>
                  <input type="file" class="propiedades" name="propiedades">
                  <p class="help-block">Ingrese el formato .CSV generado a partir de la plantilla de Excel</p>
                  
                </div>
              </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

              <button type="submit" class="btn btn-success" name="newPropertys">Subir Propiedades</button>
            </div>
        </form>

      </div>
    </div>
  </div>
@stop