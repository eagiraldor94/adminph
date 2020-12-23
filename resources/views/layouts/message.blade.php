<!--=====================================
  =          Ventana Modal Edit         =
  ======================================-->
<!-- The Modal -->
<div class="modal" id="modalEnviarMensaje">

  <div class="modal-dialog">

    <div class="modal-content">
        <form role="form" method="post" action="mensaje/{{session('rank')}}/{{session('id')}}" enctype="multipart/form-data">
          @csrf
          <!-- Modal Header -->
          <div class="modal-header" style="background: #E75300 ; color: white">

            <h4 class="modal-title">Mensaje para la administración</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <!-- Modal body -->
          <div class="modal-body">
              <div class="box-body">
               <div class="row">
            <!-- Asunto -->
               <div class="form-group ml-3" style="width:93%">
                <div class="input-group mb-3">
                    <div class="input-group-prepend d-md-inline-flex">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="text" class="form-control" name="newSubject" placeholder="Asunto del mensaje">
                  <input type="hidden" name="password" id="passwordMessage">
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
                    <textarea class="form-control" name="newBody" placeholder="Ingrese el contenido de su mensaje" rows="3"></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-success" name="newMessage">Enviar Mensaje</button>
          </div>
      </form>

    </div>
  </div>
</div>