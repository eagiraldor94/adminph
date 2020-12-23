
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
  var table = $('.tablaReportes').DataTable({

  "ajax":"ajax/datatable/reportes",
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
  $(document).on( 'click', ".btnBorrarReporte" ,function(){
    var idReporte = $(this).attr("idReporte");
    var reporte = $(this).attr("reporte");
    swal({
      title: '¿Está seguro de borrar el reporte?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de reporte'
    }).then((result)=>{
      if(result.value){
      var datos = new FormData();
      datos.append("idReporte", idReporte);
      datos.append("reporte", reporte);
      $.ajax({
        url:"ajax/reportes/borrar",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
        }
      });
      window.location="reportes-danos";
      }
    });
  });
  $(document).on( 'click', ".btnCambiarPrioridad" ,function(){
    var idReporte = $(this).attr("idReporte");
    $('#nuevoIdAutorizacion').val(idReporte);
  });
});