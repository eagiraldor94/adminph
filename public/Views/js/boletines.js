
/*================================================
=            CARGAR LA TABLA DINAMICA            =
================================================*/
$(function(){
  var table = $('.tablaBoletines').DataTable({

  "ajax":"ajax/datatable/boletines",
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
  $(document).on('click', '.btnEditarBoletin' ,function(){
    var idBoletin = $(this).attr("idBoletin");
    var datos = new FormData();
    datos.append("idBoletin", idBoletin);
    $.ajax({
      url:"ajax/boletines/editar",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        $('#editId').val(answer['id']);
        $('#editIdOrganizacion').val(answer['organization_id']);
        $('#editAsunto').val(answer['subject']);
        $('#editCuerpo').val(answer['body']);
        $('#lastDocument').val(answer['link']);
    }
  });
  });
});
/*==============================================
=            EDITAR USUARIO            =
==============================================*/
$(function(){
  $(document).on('click', '.btnVerBoletin' ,function(){
    var idBoletin = $(this).attr("idBoletin");
    var idUnidad = "";
    var datos = new FormData();
    datos.append("idBoletin", idBoletin);
    $.ajax({
      url:"ajax/boletines/editar",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        idUnidad=answer['organization_id'];
        $('#verAsunto').val(answer['subject']);
        $('#verCuerpo').val(answer['body']);
    }
  });
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
        $('#verOrganizacion').val(answer['name']);
      }
    });
  });
});
/*==============================================
=            ELIMINAR USUARIO          =
==============================================*/
$(function(){
  $(document).on( 'click', ".btnBorrarBoletin" ,function(){
    var idBoletin = $(this).attr("idBoletin");
    var boletin = $(this).attr("boletin");
    swal({
      title: '¿Está seguro de borrar el boletin?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de boletin'
    }).then((result)=>{
      if(result.value){
      var datos = new FormData();
      datos.append("idBoletin", idBoletin);
      datos.append("boletin", boletin);
      $.ajax({
        url:"ajax/boletines/borrar",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
        }
      });
      window.location="boletines";
      }
    });
  });
});