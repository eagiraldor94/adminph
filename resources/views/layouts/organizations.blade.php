@extends('base_table')
	@section('title')
		Unidades
	@stop
@section('css')
@stop
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/unidades.js"></script>
@stop
@section('h1')
	Lista de Unidades
@stop
@section('small')
	Unidades
@stop
@section('texto1')
	Unidades
@stop
@section('cardHeader')
    <button class="btn btn-secondary" data-toggle="modal" data-target="#modalAgregarUnidad"> Agregar Unidad </button>
@stop
@section('nombreTabla') tabla @stop
@section('thead')
	<thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Logo</th>
        <th>Nombre</th>
        <th>Codigo</th>
        <th>Presupuesto</th>
        <th>Cuota extra</th>
        <th>Activar Coeff</th>
        <th>Descuento</th>
        <th>Porcentual</th>
        <th>Dia Desc</th>
        <th>Interés</th>
        <th>NIT</th>
        <th>Teléfono</th>
        <th>Dirección</th>
        <th>Email</th>
        <th>Ciudad</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
    	@foreach ($unidades as $key => $unidad)
          <tr>
            <td>{{$key+1}}</td>
            @if($unidad->logo != null)
            <td><img src="{{$unidad->logo}}" class="img-thumbnail" width="40px"></td>
            @else
            <td><img src="Views/img/usuarios/anonymous.png" class="img-thumbnail" width="40px"></td>
            @endif
            <td>{{$unidad->name}}</td>
            <td>{{$unidad->code}}</td>
            <td>{{$unidad->budget}}</td>
            <td>{{$unidad->extra_fee}}</td>
            @if($unidad->budget_state == 1)
            <td><button class="btn btn-success btn-sm">Activado</button></td>
            @else
            <td><button class="btn btn-danger btn-sm">Desactivado</button></td>
            @endif
            <td>{{$unidad->discount}}</td>
            @if($unidad->discount_state == 1)
            <td><button class="btn btn-success btn-sm">Si</button></td>
            @else
            <td><button class="btn btn-danger btn-sm">No</button></td>
            @endif
            <td>{{$unidad->discount_day}}</td>
            <td>{{$unidad->charge}}</td>
            <td>{{$unidad->NIT}}</td>
            <td>{{$unidad->phone}}</td>
            <td>{{$unidad->address}}</td>
            <td>{{$unidad->email}}</td>
            <td>{{$unidad->city}}</td>
            <td>
              <div class="btn-group">
                <a href="facturas/masa/{{$unidad->id}}" target="_blank"><button class="btn btn-primary btnFacturaUnidad"><i class="fas fa-print"></i></button></a>
                <button class="btn btn-warning btnEditarUnidad" idUnidad="{{$unidad->id}}" data-toggle="modal" data-target="#modalEditarUnidad"><i class="fa fa-pen"></i></button>
                <button class="btn btn-danger btnBorrarUnidad" idUnidad="{{$unidad->id}}" fotoUnidad="{{$unidad->logo}}" codigoUnidad="{{$unidad->code}}"><i class="fa fa-times"></i></button>
                
              </div>
            </td>
          </tr>
        
		@endforeach
      
    </tbody>
@stop
@section('modalAgregar') "modalAgregarUnidad" @stop
@section('textoAgregar')
    Unidad
@stop
@section('formAdd')
  <!-- nombre -->
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-building"></i></span>
        </div>
        
        <input class="form-control" type="text" id="nuevoNombre" name="newName" placeholder="Ingresar nombre de la unidad" required>
      </div>
      
    </div>
  </div>
  <!-- Documento empresa -->
  <div class="row">
    <div class="form-group ml-3" style="width:30%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
          </div>
          <input class="form-control" type="text" id="nuevoCodigo" name="newCode" placeholder="Código" required>  
        </div>
     </div>
     <div class="form-group ml-3" style="width:60%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
          </div>
          <input type="text" class="form-control" name="newNIT" id="nuevoNIT" placeholder="Ingrese el número del NIT" required>
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
        
        <input class="form-control" type="text" name="newPhone" id="nuevoTelefono" placeholder="Teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask>
        </div>
     </div>            
       <!-- email -->
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
  <!-- Municipio -->
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
          </div>
          <input type="text" class="form-control" name="newCity" id="nuevoCiudad" placeholder="Ciudad" required>
        </div>
     </div>
  <!-- Direccion -->
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
          </div>
          <input type="text" class="form-control" name="newAddress" id="nuevoDireccion" placeholder="Ingrese dirección" required>
        </div>
     </div>
   </div>
  <!-- Documento empresa -->
  <div class="row">
    <div class="form-group ml-3" style="width:30%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-percentage"></i></span>
          </div>
        <select name="newDiscountState" id="nuevoEstadoDescuento" class="form-control" required>
          <option value="">Tipo de descuento</option>
          <option value="1">Porcentual</option>
          <option value="0">Fijo</option>
        </select>
        </div>
     </div>
     <div class="form-group ml-3" style="width:60%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-calculator"></i></span>
          </div>
          <input title="Ingrese el valor si es fijo, o el porcentaje si es porcentual. Como un número y sin simbolos." type="number" step="0.01" class="form-control" name="newDiscount" id="nuevoDescuento" placeholder="Monto descuento">
        </div>
     </div>
   </div>
    <!-- Dia de descuento -->
    <div class="row">
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
        </div>
        
        <input class="form-control" type="number" name="newDiscountDay" id="nuevoDiaDescuento" placeholder="Día para descuento">
        </div>
     </div>            
       <!-- Interes -->
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-percentage"></i></span>
        </div>
        
        <input title="Ingrese el valor como un número y sin simbolos." class="form-control" step="0.01" type="number" name="newCharge" id="nuevoInteres" placeholder="Porcentaje Interés">
      </div>
      
    </div>
   </div>
    <!-- Administracion -->
    <div class="row">
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-money-bill-wave-alt"></i></span>
        </div>
        
        <input class="form-control" type="number" name="newBudget" id="nuevoPresupuesto" placeholder="Presupuesto">
        </div>
     </div>            
       <!-- Cuota extra -->
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-money-bill-wave-alt"></i></span>
        </div>
        
        <input class="form-control" type="number" name="newExtraFee" id="nuevoCuotaExtra" placeholder="Cuota extra">
      </div>
      
    </div>
   </div>
  <!-- Documento empresa -->
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-wallet"></i></span>
          </div>
        <select name="newBudgetState" id="nuevoEstadoPresupuesto" class="form-control" required>
          <option value="">Usar presupuesto</option>
          <option value="1">Si</option>
          <option value="0">No</option>
        </select>
        </div>
     </div>
   </div>
  <!-- Documento empresa -->
  <div class="row">
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
          </div>
        <select name="newAccountType" id="nuevoTipoCuenta" class="form-control" required>
          <option value="">Tipo cuenta</option>
          <option value="Ahorros">Ahorros</option>
          <option value="Corriente">Corriente</option>
        </select>
        </div>
     </div>
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-university"></i></span>
          </div>
          <input type="text" class="form-control" name="newBank" id="nuevoBanco" placeholder="Banco">
        </div>
     </div>
   </div>
  <!-- Documento empresa -->
  <div class="row">
     <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-piggy-bank"></i></span>
          </div>
          <input type="text" class="form-control" name="newAccountNumber" id="nuevoNumeroCuenta" placeholder="Número de cuenta">
        </div>
     </div>
  </div>
  <!-- Documento empresa -->
  <div class="row">
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
          </div>
          <input type="text" class="form-control" name="newBalotoCode" id="nuevoCodigoBaloto" placeholder="Codigo baloto">
        </div>
     </div>
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
          </div>
          <input type="text" class="form-control" name="newRedebanCode" id="nuevoCodigoRedeban" placeholder="Codigo redeban">
        </div>
     </div>
   </div>
   <div class="row">
    <!-- foto -->
    <div class="form-group ml-3" style="width:93%">
      <div class="panel">SUBIR LOGO</div>
      <input type="file" class="logo" name="logo">
      <p class="help-block">Peso máximo del logo 2MB</p>
      <img src="Views/img/usuarios/anonymous.png" class="img-thumbnail previsualizar" width="100px">
    </div>
  </div>
  <!-- link -->
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-shopping-cart"></i></span>
        </div>
        
        <input class="form-control" type="text" id="nuevoEnlace" name="newLink" placeholder="Ingresar enlace pagos en línea">
      </div>
      
    </div>
  </div>
  <div class="row">
    <!-- Placas -->
  <div class="form-group ml-3" style="width: 93%">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
      </div>
      <textarea class="form-control" name="newMessage" placeholder="Ingrese el mensaje para la factura" id="nuevoMensaje" rows="2"></textarea>
    </div>
  </div>
</div>
  <div class="row">
    <div class="form-group">
      <div class="input-group mb-3">
        <div class="alert alert-warning">
        <h2>A CONTINUACIÓN ESTABLEZCA EL ORDEN DE PRIORIDAD AL APLICAR LOS PAGOS</h2>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newFirstId" id="nuevoPrimerId" class="form-control" required>
          <option value="">Primero</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newSecondId" id="nuevoSegundoId" class="form-control" required>
          <option value="">Segundo</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newThirdId" id="nuevoTercerId" class="form-control" required>
          <option value="">Tercero</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newFourthId" id="nuevoCuartoId" class="form-control" required>
          <option value="">Cuarto</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newFifthId" id="nuevoQuintoId" class="form-control" required>
          <option value="">Quinto</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newSixthId" id="nuevoSextoId" class="form-control" required>
          <option value="">Sexto</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newSeventhId" id="nuevoSeptimoId" class="form-control" required>
          <option value="">Septimo</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newEighthId" id="nuevoOctavoId" class="form-control" required>
          <option value="">Octavo</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newNinethId" id="nuevoNovenoId" class="form-control" required>
          <option value="">Noveno</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newTenthId" id="nuevoDecimoId" class="form-control" required>
          <option value="">Decimo</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
@stop
@section('nameNew') "newOrganization" @stop
@section('textoAgregar2')
    Unidad
@stop
@section('modalEditar') "modalEditarUnidad" @stop
@section('actionEditar') "unidades/editar" @stop
@section('textoEditar')
    Unidad
@stop
@section('formEdit')

  <!-- nombre -->
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-building"></i></span>
        </div>
        
        <input class="form-control" type="text" id="editNombre" name="newName" placeholder="Ingresar nombre de la unidad" required>

        <input type="hidden" name="editId" id="editId" required>
      </div>
      
    </div>
  </div>
  <!-- Documento empresa -->
  <div class="row">
    <div class="form-group ml-3" style="width:30%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
          </div>
          <input class="form-control" type="text" id="editCodigo" name="newCode" placeholder="Código" required>  
        </div>
     </div>
     <div class="form-group ml-3" style="width:60%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
          </div>
          <input type="text" class="form-control" name="newNIT" id="editNIT" placeholder="Ingrese el número del NIT" required>
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
        
        <input class="form-control" type="text" name="newPhone" id="editTelefono" placeholder="Teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask>
        </div>
     </div>            
       <!-- email -->
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
  <!-- Municipio -->
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
          </div>
          <input type="text" class="form-control" name="newCity" id="editCiudad" placeholder="Ciudad" required>
        </div>
     </div>
  <!-- Direccion -->
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
          </div>
          <input type="text" class="form-control" name="newAddress" id="editDireccion" placeholder="Ingrese dirección" required>
        </div>
     </div>
   </div>
  <!-- Documento empresa -->
  <div class="row">
    <div class="form-group ml-3" style="width:30%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-percentage"></i></span>
          </div>
        <select name="newDiscountState" id="editEstadoDescuento" class="form-control" required>
          <option value="">Tipo de descuento</option>
          <option value="1">Porcentual</option>
          <option value="0">Fijo</option>
        </select>
        </div>
     </div>
     <div class="form-group ml-3" style="width:60%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-calculator"></i></span>
          </div>
          <input title="Ingrese el valor si es fijo, o el porcentaje si es porcentual. Como un número y sin simbolos." type="number" step="0.01" class="form-control" name="newDiscount" id="editDescuento" placeholder="Monto descuento">
        </div>
     </div>
   </div>
    <!-- Dia de descuento -->
    <div class="row">
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
        </div>
        
        <input class="form-control" type="number" name="newDiscountDay" id="editDiaDescuento" placeholder="Día para descuento">
        </div>
     </div>            
       <!-- Interes -->
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-percentage"></i></span>
        </div>
        
        <input title="Ingrese el valor como un número y sin simbolos." step="0.01" class="form-control" type="number" name="newCharge" id="editInteres" placeholder="Porcentaje Interés">
      </div>
      
    </div>
   </div>
    <!-- Administracion -->
    <div class="row">
      <div class="form-group ml-3" style="width:45%">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-money-bill-wave-alt"></i></span>
        </div>
        
        <input class="form-control" type="number" name="newBudget" id="editPresupuesto" placeholder="Presupuesto">
        </div>
     </div>            
       <!-- Cuota extra -->
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-money-bill-wave-alt"></i></span>
        </div>
        
        <input class="form-control" type="number" name="newExtraFee" id="editCuotaExtra" placeholder="Cuota extra">
      </div>
      
    </div>
   </div>
  <!-- Documento empresa -->
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-wallet"></i></span>
          </div>
        <select name="newBudgetState" id="editEstadoPresupuesto" class="form-control" required>
          <option value="">Usar presupuesto</option>
          <option value="1">Si</option>
          <option value="0">No</option>
        </select>
        </div>
     </div>
   </div>
  <!-- Documento empresa -->
  <div class="row">
    <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
          </div>
        <select name="newAccountType" id="editTipoCuenta" class="form-control" required>
          <option value="">Tipo cuenta</option>
          <option value="Ahorros">Ahorros</option>
          <option value="Corriente">Corriente</option>
        </select>
        </div>
     </div>
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-university"></i></span>
          </div>
          <input type="text" class="form-control" name="newBank" id="editBanco" placeholder="Banco">
        </div>
     </div>
   </div>
  <!-- Documento empresa -->
  <div class="row">
     <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-piggy-bank"></i></span>
          </div>
          <input type="text" class="form-control" name="newAccountNumber" id="editNumeroCuenta" placeholder="Número de cuenta">
        </div>
     </div>
   </div>
  <!-- Documento empresa -->
  <div class="row">
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
          </div>
          <input type="text" class="form-control" name="newBalotoCode" id="editCodigoBaloto" placeholder="Codigo baloto">
        </div>
     </div>
     <div class="form-group ml-3" style="width:45%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
          </div>
          <input type="text" class="form-control" name="newRedebanCode" id="editCodigoRedeban" placeholder="Codigo redeban">
        </div>
     </div>
   </div>
   <div class="row">
    <!-- foto -->
    <div class="form-group ml-3" style="width:93%">
      <div class="panel">SUBIR LOGO</div>
      <input type="file" class="logo" name="logo">
      <p class="help-block">Peso máximo del logo 2MB</p>
      <img src="Views/img/usuarios/anonymous.png" class="img-thumbnail previsualizar" width="100px">
    <input type="hidden" name="lastLogo" id="lastLogo">
    </div>
  </div>
  <!-- link -->
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-shopping-cart"></i></span>
        </div>
        
        <input class="form-control" type="text" id="editEnlace" name="newLink" placeholder="Ingresar enlace pagos en línea">
      </div>
      
    </div>
  </div>
  <div class="row">
    <!-- Placas -->
  <div class="form-group ml-3" style="width: 93%">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
      </div>
      <textarea class="form-control" name="newMessage" placeholder="Ingrese el mensaje para la factura" id="editMensaje" rows="2"></textarea>
    </div>
  </div>
</div>
  <div class="row">
    <div class="form-group">
      <div class="input-group mb-3">
        <div class="alert alert-warning">
        <h2>A CONTINUACIÓN ESTABLEZCA EL ORDEN DE PRIORIDAD AL APLICAR LOS PAGOS</h2>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newFirstId" id="editPrimerId" class="form-control" required>
          <option value="">Primero</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newSecondId" id="editSegundoId" class="form-control" required>
          <option value="">Segundo</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newThirdId" id="editTercerId" class="form-control" required>
          <option value="">Tercero</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newFourthId" id="editCuartoId" class="form-control" required>
          <option value="">Cuarto</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newFifthId" id="editQuintoId" class="form-control" required>
          <option value="">Quinto</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newSixthId" id="editSextoId" class="form-control" required>
          <option value="">Sexto</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newSeventhId" id="editSeptimoId" class="form-control" required>
          <option value="">Septimo</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newEighthId" id="editOctavoId" class="form-control" required>
          <option value="">Octavo</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newNinethId" id="editNovenoId" class="form-control" required>
          <option value="">Noveno</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
  <div class="row">
    <div class="form-group ml-3" style="width:93%">
      <div class="input-group mb-3">
          <div class="input-group-prepend d-md-inline-flex">
          <span class="input-group-text"><i class="fas fa-cogs"></i></span>
          </div>
        <select name="newTenthId" id="editDecimoId" class="form-control" required>
          <option value="">Decimo</option>
          @foreach ($conceptos as $key => $concepto)
          <option value="{{$concepto->id}}">{{$concepto->name}}</option>
          @endforeach
        </select>
        </div>
     </div>
  </div>
@stop
@section('nameEdit') "editOrganization" @stop
@section('textoEditar2')
    Unidad
@stop
@section('moreForms')
@stop