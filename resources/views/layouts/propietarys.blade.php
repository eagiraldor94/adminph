@extends('base_table')
	@section('title')
		Propietarios
	@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/propietarios.js"></script>
@stop
@section('h1')
	Lista de Propietarios
@stop
@section('small')
	Propietarios
@stop
@section('texto1')
	Propietarios
@stop
@section('cardHeader')
    <button class="btn btn-secondary pull-left" data-toggle="modal" data-target="#modalAgregarPropietario"> Agregar Propietario </button>
    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalSubirPropietarios"> Subir Propietarios </button>
@stop
@section('nombreTabla') tablaPropietarios @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Unidad</th>
        <th>Apto</th>
        <th>Nombre</th>
        <th>Tipo Doc</th>
        <th>Documento</th>
        <th>Teléfonos</th>
        <th>Emails</th>
        <th>Dirección</th>
        <th>Usuario</th>
        <th>Estado</th>
        <th>Último login</th>
        <th>Acciones</th>
      </tr>
    </thead>
@stop
@section('modalAgregar') "modalAgregarPropietario" @stop
@section('textoAgregar')
    Propietario
@stop
@section('formAdd')
  <!-- nombre -->
  <div class="row">  
    <div class="form-group ml-3" style="width: 93%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-user"></i></span>
        </div>
        <input class="form-control" type="text" id="nuevoNombre" name="newName" placeholder="Ingresar nombre" required>
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
            <option value="TI">Tarjeta de identidad</option>
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
              <option value="{{$unidad->id}}"> {{$unidad->name}} </option>
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
    <!-- Telefono 1 -->
    <div class="row">
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
        </div>
        
        <input class="form-control" type="text" name="newPhone1" id="nuevoTelefono1" placeholder="Telefono 1" data-inputmask="'mask':'(999) 999-9999'" data-mask>
      </div>
       </div>
    <!-- Telefono 2 -->
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
        </div>
        
        <input class="form-control" type="text" name="newPhone2" id="nuevoTelefono2" placeholder="Telefono 2" data-inputmask="'mask':'(999) 999-9999'" data-mask>
      </div>
       </div>
     </div>
    <!-- Email 1 -->
    <div class="row">
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-envelope"></i></span>
        </div>
        
        <input class="form-control" type="email" name="newEmail1" id="nuevoEmail1" placeholder="Email 1">
      </div>
       </div>
    <!-- Email 2 -->
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-envelope"></i></span>
        </div>
        
        <input class="form-control" type="email" name="newEmail2" id="nuevoEmail2" placeholder="Email 2">
      </div>
       </div>
     </div>
     <div class="row">
  <!-- Direccion -->
     <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
          </div>
          <input type="text" class="form-control" name="newAddress" id="nuevoDireccion" placeholder="Dirección">
        </div>
     </div>
     </div>
  <!-- username -->
  <div class="row">
  <div class="form-group ml-3" style="width: 93%">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-key"></i></span>
      </div>
      
      <input class="form-control" type="text" name="newUsername" placeholder="Ingresar nombre de usuario" id="nuevoUsuario" required>
    </div>
    
  </div>
  </div>
  <!-- contraseña -->
  <div class="row">
  <div class="form-group ml-3" style="width: 93%">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-lock"></i></span>
      </div>
      
      <input class="form-control" type="password" name="newPassword" id="nuevoContraseña" placeholder="Ingresar contraseña" required>
    </div>
    
  </div>
  </div>
  <!-- foto -->
  <div class="row">
  <div class="form-group ml-3" style="width: 93%">
    <div class="panel">SUBIR FOTO</div>
    <input type="file" class="photo" name="photo">
    <p class="help-block">Peso máximo de la foto 2MB</p>
    <img src="Views/img/usuarios/anonymous.png" class="img-thumbnail previsualizar" width="100px" id="newPhoto">
  </div>
</div>
@stop
@section('nameNew') "newPropietary" @stop
@section('textoAgregar2')
    Propietario
@stop
@section('modalEditar') "modalEditarPropietario" @stop
@section('actionEditar') "propietarios/editar" @stop
@section('textoEditar')
    Propietario
@stop
@section('formEdit')
  <!-- nombre -->
  <div class="row">  
    <div class="form-group ml-3" style="width: 93%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-user"></i></span>
        </div>
        <input class="form-control" type="text" id="editNombre" name="newName" placeholder="Ingresar nombre" required>
        <input type="hidden" name="editId" id="editId" required>
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
          <select id="editTipoDocumento" name="newIdType" class="form-control" required>
            <option value="">Tipo de documento</option>
            <option value="CC">Cedula de ciudadanía</option>
            <option value="CE">Cedula de extrajería</option>
            <option value="NIT">NIT</option>
            <option value="TI">Tarjeta de identidad</option>
          </select>
        </div>
     </div>
     <div class="form-group ml-3" style="width:60%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
          </div>
          <input type="text" class="form-control" name="newIdNumber" id="editNumeroDocumento" placeholder="Número del documento" required>
        </div>
     </div>
   </div>
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
    <!-- Telefono 1 -->
    <div class="row">
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
        </div>
        
        <input class="form-control" type="text" name="newPhone1" id="editTelefono1" placeholder="Telefono 1" data-inputmask="'mask':'(999) 999-9999'" data-mask>
      </div>
       </div>
    <!-- Telefono 2 -->
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
        </div>
        
        <input class="form-control" type="text" name="newPhone2" id="editTelefono2" placeholder="Telefono 2" data-inputmask="'mask':'(999) 999-9999'" data-mask>
      </div>
       </div>
     </div>
    <!-- Email 1 -->
    <div class="row">
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-envelope"></i></span>
        </div>
        
        <input class="form-control" type="email" name="newEmail1" id="editEmail1" placeholder="Email 1">
      </div>
       </div>
    <!-- Email 2 -->
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-envelope"></i></span>
        </div>
        
        <input class="form-control" type="email" name="newEmail2" id="editEmail2" placeholder="Email 2">
      </div>
       </div>
     </div>
     <div class="row">
  <!-- Direccion -->
     <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
          </div>
          <input type="text" class="form-control" name="newAddress" id="editDireccion" placeholder="Dirección">
        </div>
     </div>
     </div>
  <!-- username -->
  <div class="row">
  <div class="form-group ml-3" style="width: 93%">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-key"></i></span>
      </div>
      
      <input class="form-control" type="text" name="newUsername" placeholder="Ingresar nombre de usuario" id="editUsuario" required>
    </div>
    
  </div>
  </div>
  <!-- contraseña -->
  <div class="row">
  <div class="form-group ml-3" style="width: 93%">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-lock"></i></span>
      </div>
      
      <input class="form-control" type="password" name="newPassword" id="editContraseña" placeholder="Ingresar contraseña">
      <input type="hidden" name="password" id="password">
    </div>
    
  </div>
  </div>
  <!-- foto -->
  <div class="row">
  <div class="form-group ml-3" style="width: 93%">
    <div class="panel">SUBIR FOTO</div>
    <input type="file" class="photo" name="photo">
    <p class="help-block">Peso máximo de la foto 2MB</p>
    <img src="Views/img/usuarios/anonymous.png" class="img-thumbnail previsualizar" width="100px" id="photoEdit">
    <input type="hidden" name="lastPhoto" id="lastPhoto">
  </div>
  </div>
@stop
@section('nameEdit') "editPropietary" @stop
@section('textoEditar2')
    Propietario
@stop
@section('moreForms')
  <!--=====================================
  =          Ventana Modal Edit         =
  ======================================-->
<!-- The Modal -->
<div class="modal" id="modalSubirPropietarios">

    <div class="modal-dialog">

      <div class="modal-content">
          <form role="form" method="post" action="propietarios/subir" enctype="multipart/form-data">
            @csrf
            <!-- Modal Header -->
            <div class="modal-header" style="background: #E75300 ; color: white">

              <h4 class="modal-title">Subir Propietarios</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <div class="box-body">
                <!-- foto -->
                <div class="form-group">
                  <div class="panel">Subir Propietarios</div>
                  <input type="file" class="propietarios" name="propietarios">
                  <p class="help-block">Ingrese el formato .CSV generado a partir de la plantilla de Excel</p>
                  
                </div>
              </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

              <button type="submit" class="btn btn-success" name="newPropietarys">Subir Propietarios</button>
            </div>
        </form>

      </div>
    </div>
  </div>
@stop