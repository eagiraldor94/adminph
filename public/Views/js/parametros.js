/*==============================================
=            EDITAR USUARIO            =
==============================================*/
$(function(){
  $(document).on('click', '.btnUpdate' ,function(){
    var idParametro = $(this).attr("idParametro");
    var inputValor = $(this).attr("idCampo")
    var valor = $(inputValor).val();
    var datos = new FormData();
    datos.append("idParametro", idParametro);
    datos.append("newValue", valor);
    $.ajax({
      url:"parametros/editar",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        window.location = "parametros";
      }
    })
  });
  $(document).on('change','.sign',function(){
  var imagen = this.files[0];
  // validar imagen jpg o png
  if(imagen['type'] != "image/jpeg" && imagen['type'] != "image/png"){
    $('.sign').val("");
    swal({
          title: "Error al subir la imagen",
          text: "La imagen debe estar en formato JPG o PNG",
          type: "error",
          confirmButtonText: "¡Entendido!"
        });
  }else if(imagen['size'] > 2097152){
    $('.sign').val("");
    swal({
          title: "Error al subir la imagen",
          text: "La imagen debe pesar menos de 2MB",
          type: "error",
          confirmButtonText: "¡Entendido!"
        });  
  }
});
});