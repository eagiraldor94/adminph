
/*================================================
=            CARGAR LA TABLA DINAMICA            =
================================================*/
$(function(){
  $(document).on('change','.document',function(){
  var imagen = this.files[0];
  // validar imagen pdf
  if(imagen['type'] != "application/pdf" && imagen['type'] != "image/jpeg" && imagen['type'] != "image/png"){
    $('.document').val("");
    swal({
          title: "Error al subir el documento",
          text: "El documento debe estar en formato PDF, JPG o PNG",
          type: "error",
          confirmButtonText: "¡Entendido!"
        });
  }else if(imagen['size'] > 2097152){
    $('.document').val("");
    swal({
          title: "Error al subir el documento",
          text: "El documento debe pesar menos de 2MB",
          type: "error",
          confirmButtonText: "¡Entendido!"
        });  
  }
});
  $(document).on('change','.photo',function(){
  var imagen = this.files[0];
  // validar imagen pdf
  if(imagen['type'] != "image/jpeg" && imagen['type'] != "image/png"){
    $('.photo').val("");
    swal({
          title: "Error al subir la foto",
          text: "El documento debe estar en formato JPG o PNG",
          type: "error",
          confirmButtonText: "¡Entendido!"
        });
  }else if(imagen['size'] > 2097152){
    $('.photo').val("");
    swal({
          title: "Error al subir la foto",
          text: "El documento debe pesar menos de 2MB",
          type: "error",
          confirmButtonText: "¡Entendido!"
        });  
  }
});
  $(document).on( 'click', ".btnVerClasificado" ,function(){
    var idClasificado = $(this).attr("idClasificado");
    var datos = new FormData();
    datos.append("idClasificado", idClasificado);
    $.ajax({
      url:"/ajax/clasificados/editar",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        $('#verOrganizacion').val(answer.organization.code);
        $('#verApartamento').val(answer.property.apartment);
        $('#verNombre').val(answer.name);
        $('#verTelefono').val(answer.phone);
        $('#verEmail').val(answer.email);
        $('#verAsunto').val(answer.subject);
        $('#verCuerpo').html(answer.body);
        $('#verDocumento').attr("href",'/'+answer.document);
      }
    })
  });
});