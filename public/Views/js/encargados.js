
/*================================================
=            CARGAR LA TABLA DINAMICA            =
================================================*/
$(function(){
  var table = $('.tablaEncargados').DataTable({

  "ajax":"ajax/datatable/encargados",
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  "language": {

    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
    "sFirst":    "Primero",
    "sLast":     "Último",
    "sNext":     "Siguiente",
    "sPrevious": "Anterior"
    },
    "oAria": {
      "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }

  }


 });
});
/*==============================================
=            EDITAR USUARIO            =
==============================================*/
$(function(){
  $(document).on('click', '.btnEditarEncargado' ,function(){
    var idEncargado = $(this).attr("idEncargado");
    var idUnidad;
    var idApartamento;
    var datos = new FormData();
    datos.append("idEncargado", idEncargado);
    $.ajax({
      url:"ajax/encargados/editar",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        $('#editId').val(answer['id']);
        $('#editIdOrganizacion').val(answer['organization_id']);
        $('#editNombre').val(answer['name']);
        $('#editTipoDocumento').val(answer['id_type']);
        $('#editNumeroDocumento').val(answer['id_number']);
        idUnidad = answer['organization_id'];
        idApartamento = answer['property_id'];
        $('#editTelefono').val(answer['phone']);
        $('#editEmail').val(answer['email']);
        $('#editDireccion').val(answer['address']);
        $('#editUsuario').val(answer['username']);
        $('#password').val(answer['password']);
        $('#lastPhoto').val(answer['photo']);
        if (answer['photo'] != "" && answer['photo'] != null) {
          $('#photoEdit').attr("src",answer['photo']);
        }
    }, 
    async: false
  });
    var datos = new FormData();
    datos.append("idUnidad", idUnidad);
    $.ajax({
      url:"ajax/propiedades/consultar",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (answer) {
          answer.forEach(funcionForEach);
          function funcionForEach(item,index){
               $("#editIdPropiedad").append(
                '<option value="'+item.id+'">'+item.apartment+'</option>'
              ) 
             }
        $('#editIdPropiedad').val(idApartamento);
        }
    }
  });
  });
});
/*==============================================
=            ACTIVAR O DESACTIVAR USUARIO      =
==============================================*/
$(function(){
  $(document).on('click', '.btnActivar' ,function(){
    var idEncargado = $(this).attr("idEncargado");
    var estadoEncargado = $(this).attr("estadoEncargado");
    var datos = new FormData();
    datos.append("activarEncargado", idEncargado);

    datos.append("estadoEncargado", estadoEncargado);
    $.ajax({
      url:"ajax/encargados/activar",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(answer){
        window.location = "encargados";
      }
    })
  });
});
/*==============================================
=            VERIFICACION DE USERNAME          =
==============================================*/
$(function(){
  $(document).on( 'change', '#nuevoUsuario' ,function(){
    $(".alert").remove();
    var username = $(this).val();
    var datos = new FormData();
    datos.append("userCheck", username);
    $.ajax({
      url:"ajax/encargados/check",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (answer) {
            $("#nuevoUsuario").parent().after('<div class="alert alert-warning">Este usuario ya se encuentra registrado</div>');
            $("#nuevoUsuario").val("");
        }
      }
    })
  });
});
/*==============================================
=            VERIFICACION DE USERNAME          =
==============================================*/
$(function(){
  $(document).on( 'change', '#editUsuario' ,function(){
    $(".alert").remove();
    var username = $(this).val();
    var datos = new FormData();
    datos.append("userCheck", username);
    $.ajax({
      url:"ajax/encargados/check",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (answer) {
            $("#editUsuario").parent().after('<div class="alert alert-warning">Este usuario ya se encuentra registrado</div>');
            $("#editUsuario").val("");
        }
      }
    })
  });
});
/*==============================================
=            CONSULTA DE PROPIEDADES          =
==============================================*/
$(function(){
  $(document).on( 'change', '#editIdOrganizacion' ,function(){
    $('#editIdPropiedad').children().remove();
    var idUnidad = $(this).val();
    var datos = new FormData();
    datos.append("idUnidad", idUnidad);
    $.ajax({
      url:"ajax/propiedades/consultar",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (answer) {
          answer.forEach(funcionForEach);
          function funcionForEach(item,index){
               $("#editIdPropiedad").append(
                '<option value="'+item.id+'">'+item.apartment+'</option>'
              ) 
             }
        }
      }
    })
  });
});
/*==============================================
=            CONSULTA DE PROPIEDADES          =
==============================================*/
$(function(){
  $(document).on( 'change', '#nuevoIdOrganizacion' ,function(){
    $('#nuevoIdPropiedad').children().remove();
    var idUnidad = $(this).val();
    var datos = new FormData();
    datos.append("idUnidad", idUnidad);
    $.ajax({
      url:"ajax/propiedades/consultar",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (answer) {
          answer.forEach(funcionForEach);
          function funcionForEach(item,index){
               $("#nuevoIdPropiedad").append(
                '<option value="'+item.id+'">'+item.apartment+'</option>'
              ) 
             }
        }
      }
    })
  });
});
/*==============================================
=            ELIMINAR USUARIO          =
==============================================*/
$(function(){
  $(document).on( 'click', ".btnBorrarEncargado" ,function(){
    var idEncargado = $(this).attr("idEncargado");
    var fotoEncargado = $(this).attr("fotoEncargado");
    var encargado = $(this).attr("encargado");
    swal({
      title: '¿Está seguro de borrar el encargado?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de encargado'
    }).then((result)=>{
      if(result.value){
      var datos = new FormData();
      datos.append("idEncargado", idEncargado);
      datos.append("fotoEncargado", fotoEncargado);
      datos.append("encargado", encargado);
      $.ajax({
        url:"ajax/encargados/borrar",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
        }
      });
      window.location="encargados";
      }
    });
  });
});