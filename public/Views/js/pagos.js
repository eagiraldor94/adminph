
/*================================================
=            CARGAR LA TABLA DINAMICA            =
================================================*/
$(function(){
  var table = $('.tablaPagos').DataTable({

  "ajax":"ajax/datatable/pagos",
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
  $(document).on('click', '.btnEditarPago' ,function(){
    var idPago = $(this).attr("idPago");
    var idUnidad;
    var idApartamento;
    var datos = new FormData();
    datos.append("idPago", idPago);
    $.ajax({
      url:"ajax/pagos/editar",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        $('#editId').val(answer['id']);
        $('#editIdOrganizacion').val(answer['organization_id']);
        idUnidad = answer['organization_id'];
        idApartamento = answer['property_id'];
        $('#editFechaPago').val(answer['payment_date']);
        $('#editDocumentoReferencia').val(answer['ref_document']);
        $('#editMonto').val(answer['amount']);
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
  $(document).on( 'click', ".btnBorrarPago" ,function(){
    var idPago = $(this).attr("idPago");
    swal({
      title: '¿Está seguro de borrar el pago?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de pago'
    }).then((result)=>{
      if(result.value){
      var datos = new FormData();
      datos.append("idPago", idPago);
      $.ajax({
        url:"ajax/pagos/borrar",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
        }
      });
      window.location="pagos";
      }
    });
  });
});