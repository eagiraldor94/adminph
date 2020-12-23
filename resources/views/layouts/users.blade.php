@extends('base_table')
	@section('title')
		Usuarios
	@stop
@section('css')
@stop
@section('js')
@stop
@section('h1')
	Lista de Usuarios
@stop
@section('small')
	Usuarios
@stop
@section('texto1')
	Usuarios
@stop
@section('cardHeader')
    <button class="btn btn-secondary" data-toggle="modal" data-target="#modalAgregarUsuario"> Agregar Usuario </button>
@stop
@section('nombreTabla') tabla @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Nombre</th>
        <th>Usuario</th>
        <th>Foto</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>Último login</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
    	@foreach ($usuarios as $key => $usuario)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$usuario->name}}</td>
            <td>{{$usuario->username}}</td>
            @if($usuario->photo != null)
            <td><img src="{{$usuario->photo}}" class="img-thumbnail" width="40px"></td>
            @else
            <td><img src="Views/img/usuarios/anonymous.png" class="img-thumbnail" width="40px"></td>
            @endif
            <td>{{$usuario->type}}</td>
            @if($usuario->state == 1)
            <td><button class="btn btn-success btn-sm btnActivar" idUsuario="{{$usuario->id}}" estadoUsuario="0">Activado</button></td>
            @else
            <td><button class="btn btn-danger btn-sm btnActivar" idUsuario="{{$usuario->id}}" estadoUsuario="1">Desactivado</button></td>
            @endif
            <td>{{$usuario->last_log}}</td>
            <td>
              <div class="btn-group">
                <button class="btn btn-warning btnEditarUsuario" idUsuario="{{$usuario->id}}" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-pen"></i></button>
                <button class="btn btn-danger btnBorrarUsuario" idUsuario="{{$usuario->id}}" fotoUsuario="{{$usuario->photo}}" usuario="{{$usuario->username}}"><i class="fa fa-times"></i></button>
                
              </div>
            </td>
          </tr>
        
		@endforeach
      
    </tbody>
@stop
@section('modalAgregar') "modalAgregarUsuario" @stop
@section('textoAgregar')
    Usuario
@stop
@section('formAdd')
  <!-- nombre -->
  <div class="form-group">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-user"></i></span>
      </div>
      
      <input class="form-control" type="text" name="newName" placeholder="Ingresar nombre" required>
    </div>
    
  </div>
  <!-- username -->
  <div class="form-group">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-key"></i></span>
      </div>
      
      <input class="form-control" type="text" name="newUsername" placeholder="Ingresar nombre de usuario" id="newUser" required>
    </div>
    
  </div>
  <!-- contraseña -->
  <div class="form-group">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-lock"></i></span>
      </div>
      
      <input class="form-control" type="password" name="newPassword" placeholder="Ingresar contraseña" required>
    </div>
    
  </div>
  <div class="form-group">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-users"></i></span>
      </div>
      <select class="form-control" name="rol">
        <option value="">Seleccione un rango</option>
        <option value="Admin">Administrador</option>
        <option value="Concejo">Miembro del concejo</option>
        <option value="Vigilante">Vigilante</option>
      </select>
    </div>
    
  </div>
    <div class="form-group">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-building"></i></span>
          </div>
        <select title="Aplicable a miembros del concejo o vigilantes" name="newOrganizationCode" class="form-control">
          <option value="">Seleccione la unidad</option>
          @foreach ($unidades as $key => $unidad)
          <option value="{{$unidad->code}}">{{$unidad->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  <!-- foto -->
  <div class="form-group">
    <div class="panel">SUBIR FOTO</div>
    <input type="file" class="photo" name="photo">
    <p class="help-block">Peso máximo de la foto 2MB</p>
    <img src="Views/img/usuarios/anonymous.png" class="img-thumbnail previsualizar" width="100px">
  </div>
@stop
@section('nameNew') "newUser" @stop
@section('textoAgregar2')
    Usuario
@stop
@section('modalEditar') "modalEditarUsuario" @stop
@section('actionEditar') "usuarios/editar" @stop
@section('textoEditar')
    Usuario
@stop
@section('formEdit')
  <!-- nombre -->
  <div class="form-group">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-user"></i></span>
      </div>
      
      <input class="form-control" type="text" name="newName" value="Editar nombre" placeholder="Editar nombre" id="nameEdit" required>
    </div>
    
  </div>
  <!-- username -->
  <div class="form-group">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-key"></i></span>
      </div>
      
      <input class="form-control" type="text" name="newUsername" value="Editar nombre de usuario" placeholder="Editar nombre de usuario" id="usernameEdit" readonly>
    </div>
    
  </div>
  <!-- contraseña -->
  <div class="form-group">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-lock"></i></span>
      </div>
      
      <input class="form-control" type="password" name="newPassword" placeholder="Escriba la nueva contraseña (opcional)">
      <input type="hidden" name="password" id="password">
    </div>
    
  </div>
  <!-- rol -->
  <div class="form-group">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-users"></i></span>
      </div>
      <select class="form-control" name="rol">
        <option value="" id="rolEdit">Seleccione un rango</option>
        <option value="Admin">Administrador</option>
        <option value="Concejo">Miembro del concejo</option>
        <option value="Vigilante">Vigilante</option>
      </select>
    </div>
    
  </div>
    <div class="form-group">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-building"></i></span>
          </div>
        <select title="Aplicable a miembros del concejo o vigilantes" name="newOrganizationCode" id="editCodigoUnidad" class="form-control">
          <option value="">Seleccione la unidad</option>
          @foreach ($unidades as $key => $unidad)
          <option value="{{$unidad->code}}">{{$unidad->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  <!-- foto -->
  <div class="form-group">
    <div class="panel">ACTUALIZAR FOTO</div>
    <input type="file" class="photo" name="photo">
    <p class="help-block">Peso máximo de la foto 2MB</p>
    <img src="Views/img/usuarios/anonymous.png" class="img-thumbnail previsualizar" width="100px" id="photoEdit">
    <input type="hidden" name="lastPhoto" id="lastPhoto">
    
  </div>
@stop
@section('nameEdit') "editUser" @stop
@section('textoEditar2')
    Usuario
@stop
@section('moreForms')
@stop