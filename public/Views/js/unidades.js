/*==============================================
=            SUBIR FOTO DEL USUARIO            =
==============================================*/
$(function(){
  $(document).on('change','.logo',function(){
  var imagen = this.files[0];
  // validar imagen jpg o png
  if(imagen['type'] != "image/jpeg" && imagen['type'] != "image/png"){
    $('.logo').val("");
    swal({
          title: "Error al subir la imagen",
          text: "La imagen debe estar en formato JPG o PNG",
          type: "error",
          confirmButtonText: "¡Entendido!"
        });
  }else if(imagen['size'] > 2097152){
    $('.logo').val("");
    swal({
          title: "Error al subir la imagen",
          text: "La imagen debe pesar menos de 2MB",
          type: "error",
          confirmButtonText: "¡Entendido!"
        });  
  }else{
    var datosImagen = new FileReader;
    datosImagen.readAsDataURL(imagen);

    $(datosImagen).on("load", function(event){
      var rutaImagen = event.target.result;
      $(".previsualizar").attr("src",rutaImagen);
    })
  }
});
});
/*==============================================
=            EDITAR USUARIO            =
==============================================*/
$(function(){
  $(document).on('click', '.btnEditarUnidad' ,function(){
    var idUnidad = $(this).attr("idUnidad");
    var datos = new FormData();
    datos.append("idUnidad", idUnidad);
    $.ajax({
      url:"ajax/unidades/editar",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        $('#editId').val(answer['id']);
        $('#editNombre').val(answer['name']);
        $('#editCodigo').val(answer['code']);
        $('#editNIT').val(answer['NIT']);
        $('#editTelefono').val(answer['phone']);
        $('#editEmail').val(answer['email']);
        $('#editCiudad').val(answer['city']);
        $('#editDireccion').val(answer['address']);
        $('#editEstadoDescuento').val(answer['discount_state']);
        $('#editDescuento').val(answer['discount']);
        $('#editDiaDescuento').val(answer['discount_day']);
        $('#editInteres').val(answer['charge']);
        $('#editPresupuesto').val(answer['budget']);
        $('#editCuotaExtra').val(answer['extra_fee']);
        $('#editEstadoPresupuesto').val(answer['budget_state']);
        $('#editBanco').val(answer['bank']);
        $('#editTipoCuenta').val(answer['account_type']);
        $('#editNumeroCuenta').val(answer['account_number']);
        $('#editReferenciaBancaria').val(answer['bank_reference']);
        $('#editCodigoBaloto').val(answer['baloto_code']);
        $('#editCodigoRedeban').val(answer['redeban_code']);
        $('#editEnlace').val(answer['link']);
        $('#editMensaje').val(answer['message']);
        $('#editPrimerId').val(answer['first_id']);
        $('#editSegundoId').val(answer['second_id']);
        $('#editTercerId').val(answer['third_id']);
        $('#editCuartoId').val(answer['fourth_id']);
        $('#editQuintoId').val(answer['fifth_id']);
        $('#editSextoId').val(answer['sixth_id']);
        $('#editSeptimoId').val(answer['seventh_id']);
        $('#editOctavoId').val(answer['eighth_id']);
        $('#editNovenoId').val(answer['nineth_id']);
        $('#editDecimoId').val(answer['tenth_id']);

        $('#lastLogo').val(answer['logo']);
        
        if (answer['logo'] != "") {
          $('#logoEdit').attr("src",answer['logo']);
        }
        
      }
    })
  });
});
/*==============================================
=            VERIFICACION DE  CODIGO          =
==============================================*/
$(function(){
  $(document).on( 'change', '#nuevoCodigo' ,function(){
    $(".alert").remove();
    var codigo = $(this).val();
    var datos = new FormData();
    datos.append("organizationCheck", codigo);
    $.ajax({
      url:"ajax/unidades/check",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (answer) {
            $("#nuevoCodigo").parent().after('<div class="alert alert-warning">Este codigo ya se encuentra registrado</div>');
            $("#nuevoCodigo").val("");
        }
      }
    })
  });
});
/*==============================================
=            VERIFICACION DE  CODIGO          =
==============================================*/
$(function(){
  $(document).on( 'change', '#editCodigo' ,function(){
    $(".alert").remove();
    var codigo = $(this).val();
    var datos = new FormData();
    datos.append("organizationCheck", codigo);
    $.ajax({
      url:"ajax/unidades/check",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (answer) {
            $("#editCodigo").parent().after('<div class="alert alert-warning">Este codigo ya se encuentra registrado</div>');
            $("#editCodigo").val("");
        }
      }
    })
  });
});
/*==============================================
=            ELIMINAR UNIDAD          =
==============================================*/
$(function(){
  $(document).on( 'click', ".btnBorrarUnidad" ,function(){
    var idUnidad = $(this).attr("idUnidad");
    var fotoUnidad = $(this).attr("fotoUnidad");
    var check = false;
    var codigoUnidad = $(this).attr("codigoUnidad");
    swal({
      title: '¿Está seguro de borrar la unidad?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de unidad'
    }).then((result)=>{
      if(result.value){
      var datos = new FormData();
      datos.append("idUnidad", idUnidad);
      datos.append("fotoUnidad", fotoUnidad);
      datos.append("codigoUnidad", codigoUnidad);
      $.ajax({
        url:"ajax/unidades/borrar",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
        }
      });
      window.location="unidades";
      }
    });
  });
});