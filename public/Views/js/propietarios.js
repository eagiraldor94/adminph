
/*================================================
=            CARGAR LA TABLA DINAMICA            =
================================================*/
$(function(){
  var table = $('.tablaPropietarios').DataTable({

  "ajax":"ajax/datatable/propietarios",
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
  $(document).on('click', '.btnEditarPropietario' ,function(){
    var idPropietario = $(this).attr("idPropietario");
    var idUnidad;
    var idApartamento;
    var datos = new FormData();
    datos.append("idPropietario", idPropietario);
    $.ajax({
      url:"ajax/propietarios/editar",
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
        $('#editTelefono1').val(answer['phone1']);
        $('#editTelefono2').val(answer['phone2']);
        $('#editEmail2').val(answer['email2']);
        $('#editEmail1').val(answer['email1']);
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
    var idPropietario = $(this).attr("idPropietario");
    var estadoPropietario = $(this).attr("estadoPropietario");
    var datos = new FormData();
    datos.append("activarPropietario", idPropietario);

    datos.append("estadoPropietario", estadoPropietario);
    $.ajax({
      url:"ajax/propietarios/activar",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(answer){
        window.location = "propietarios";
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
      url:"ajax/propietarios/check",
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
      url:"ajax/propietarios/check",
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
  $(document).on( 'click', ".btnBorrarPropietario" ,function(){
    var idPropietario = $(this).attr("idPropietario");
    var fotoPropietario = $(this).attr("fotoPropietario");
    var propietario = $(this).attr("propietario");
    swal({
      title: '¿Está seguro de borrar el propietario?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de propietario'
    }).then((result)=>{
      if(result.value){
      var datos = new FormData();
      datos.append("idPropietario", idPropietario);
      datos.append("fotoPropietario", fotoPropietario);
      datos.append("propietario", propietario);
      $.ajax({
        url:"ajax/propietarios/borrar",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
        }
      });
      window.location="propietarios";
      }
    });
  });
});