<!--=====================================
  =          Ventana Modal Edit         =
  ======================================-->
<!-- The Modal -->
<div class="modal" id="modalEditarInfo">

  <div class="modal-dialog">

    <div class="modal-content">
        <form role="form" method="post" action="info/{{session('rank')}}/{{session('id')}}" enctype="multipart/form-data">
          @csrf
          <!-- Modal Header -->
          <div class="modal-header" style="background: #E75300 ; color: white">

            <h4 class="modal-title">Actualizar mis datos</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="box-body">
              <!-- nombre -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newName" value="" placeholder="Cambiar nombre" id="updateNombre" required>
                </div>
              </div>
              <!-- Documento -->
              <div class="row">
                <div class="form-group ml-3" style="width:30%">
                  <div class="input-group mb-3">
                      <div class="input-group-prepend d-md-inline-flex">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                      </div>
                      <select id="updateTipoDocumento" name="newIdType" class="form-control" required>
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
                      <input type="text" class="form-control" name="newIdNumber" id="updateNumeroDocumento" placeholder="Número del documento" required>
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
                  
                  <input class="form-control" type="text" name="newPhone1" id="updateTelefono1" placeholder="Telefono 1" data-inputmask="'mask':'(999) 999-9999'" data-mask>
                </div>
                 </div>
              <!-- Telefono 2 -->
                <div class="form-group ml-3" style="width:45%">
                  <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newPhone2" id="updateTelefono2" placeholder="Telefono 2" data-inputmask="'mask':'(999) 999-9999'" data-mask>
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
                  
                  <input class="form-control" type="email" name="newEmail1" id="updateEmail1" placeholder="Email 1">
                </div>
                 </div>
              <!-- Email 2 -->
                <div class="form-group ml-3" style="width:45%">
                  <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                  </div>
                  
                  <input class="form-control" type="email" name="newEmail2" id="updateEmail2" placeholder="Email 2">
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
                    <input type="text" class="form-control" name="newAddress" id="updateDireccion" placeholder="Dirección de notificación">
                  </div>
               </div>
               </div>
            </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-success" name="updateInfo">Enviar solicitud</button>
          </div>
      </form>

    </div>
  </div>
</div>