@extends('base_table')
	@section('title')
		Encargados
	@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/encargados.js"></script>
@stop
@section('h1')
	Lista de Encargados
@stop
@section('small')
	Encargados
@stop
@section('texto1')
	Encargados
@stop
@section('cardHeader')
    <button class="btn btn-secondary" data-toggle="modal" data-target="#modalAgregarEncargado"> Agregar Encargado </button>
@stop
@section('nombreTabla') tablaEncargados @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Unidad</th>
        <th>Apartamento</th>
        <th>Nombre</th>
        <th>Tipo Doc</th>
        <th>Documento</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Dirección</th>
        <th>Usuario</th>
        <th>Estado</th>
        <th>Último login</th>
        <th>Acciones</th>
      </tr>
    </thead>
@stop
@section('modalAgregar') "modalAgregarEncargado" @stop
@section('textoAgregar')
    Encargado
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
    <!-- Telefono 1 -->
    <div class="row">
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
        </div>
        
        <input class="form-control" type="text" name="newPhone" id="nuevoTelefono" placeholder="Telefono" data-inputmask="'mask':'(999) 999-9999'" data-mask>
      </div>
       </div>
    <!-- Email 2 -->
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-envelope"></i></span>
        </div>
        
        <input class="form-control" type="email" name="newEmail" id="nuevoEmail" placeholder="Email">
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
@section('nameNew') "newAttendant" @stop
@section('textoAgregar2')
    Encargado
@stop
@section('modalEditar') "modalEditarEncargado" @stop
@section('actionEditar') "encargados/editar" @stop
@section('textoEditar')
    Encargado
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
        
        <input class="form-control" type="text" name="newPhone" id="editTelefono" placeholder="Telefono" data-inputmask="'mask':'(999) 999-9999'" data-mask>
      </div>
       </div>
    <!-- Email 2 -->
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-envelope"></i></span>
        </div>
        
        <input class="form-control" type="email" name="newEmail" id="editEmail" placeholder="Email">
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
@section('nameEdit') "editAttendant" @stop
@section('textoEditar2')
    Encargado
@stop
@section('moreForms')
@stop