@extends('base_table')
	@section('title')
		Arrendatarios
	@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/arrendatarios.js"></script>
@stop
@section('h1')
	Lista de Arrendatarios
@stop
@section('small')
	Arrendatarios
@stop
@section('texto1')
	Arrendatarios
@stop
@section('cardHeader')
    <button class="btn btn-secondary" data-toggle="modal" data-target="#modalAgregarArrendatario"> Agregar Arrendatario </button>
@stop
@section('nombreTabla') tablaArrendatarios @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Unidad</th>
        <th>Apartamento</th>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Usuario</th>
        <th>Estado</th>
        <th>Último login</th>
        <th>Acciones</th>
      </tr>
    </thead>
@stop
@section('modalAgregar') "modalAgregarArrendatario" @stop
@section('textoAgregar')
    Arrendatario
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
@section('nameNew') "newLessee" @stop
@section('textoAgregar2')
    Arrendatario
@stop
@section('modalEditar') "modalEditarArrendatario" @stop
@section('actionEditar') "arrendatarios/editar" @stop
@section('textoEditar')
    Arrendatario
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
@section('nameEdit') "editLessee" @stop
@section('textoEditar2')
    Arrendatario
@stop
@section('moreForms')
@stop