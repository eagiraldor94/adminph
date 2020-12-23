
/*================================================
=            CARGAR LA TABLA DINAMICA            =
================================================*/
$(function(){
  var table = $('.tablaClasificados').DataTable({

  "ajax":"ajax/datatable/clasificados",
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
/*==============================================
=            ELIMINAR USUARIO          =
==============================================*/
  $(document).on( 'click', ".btnBorrarClasificado" ,function(){
    var idClasificado = $(this).attr("idClasificado");
    var fotoClasificado = $(this).attr("fotoClasificado");
    var documentoClasificado = $(this).attr("documentoClasificado");
    swal({
      title: '¿Está seguro de borrar el clasificado?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de clasificado'
    }).then((result)=>{
      if(result.value){
      var datos = new FormData();
      datos.append("idClasificado", idClasificado);
      datos.append("fotoClasificado", fotoClasificado);
      datos.append("documentoClasificado", documentoClasificado);
      $.ajax({
        url:"ajax/clasificados/borrar",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
        }
      });
      window.location="clasificados";
      }
    });
  });
  $(document).on( 'click', ".btnAutorizarClasificado" ,function(){
    var idClasificado = $(this).attr("idClasificado");
    $('#nuevoAuthId').val(idClasificado);
    var datos = new FormData();
    datos.append("idClasificado", idClasificado);
    $.ajax({
      url:"ajax/clasificados/editar",
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
        $('#verDocumento').attr("href",answer.document);
      }
    })
  });
});