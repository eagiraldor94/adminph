
/*================================================
=            CARGAR LA TABLA DINAMICA            =
================================================*/
$(function(){
  $(document).on('change','.photo',function(){
  var imagen = this.files[0];
  // validar imagen jpg o png
  if(imagen['type'] != "image/jpeg" && imagen['type'] != "image/png"){
    $('.photo').val("");
    swal({
          title: "Error al subir la imagen",
          text: "La imagen debe estar en formato JPG o PNG",
          type: "error",
          confirmButtonText: "¡Entendido!"
        });
  }else if(imagen['size'] > 2097152){
    $('.photo').val("");
    swal({
          title: "Error al subir la imagen",
          text: "La imagen debe pesar menos de 2MB",
          type: "error",
          confirmButtonText: "¡Entendido!"
        });  
  }
});
  $(document).on('change','.document',function(){
  var imagen = this.files[0];
  // validar imagen pdf
  if(imagen['type'] != "application/pdf"){
    $('.document').val("");
    swal({
          title: "Error al subir el documento",
          text: "El documento debe estar en formato PDF",
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
  var table = $('.tablaVisitantes').DataTable({

  "ajax":"ajax/datatable/visitantes",
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
  $(document).on( 'click', ".btnBorrarVisitante" ,function(){
    var idVisitante = $(this).attr("idVisitante");
    var fotoVisitante = $(this).attr("fotoVisitante");
    var documentoVisitante = $(this).attr("documentoVisitante");
    swal({
      title: '¿Está seguro de borrar el visitante?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de visitante'
    }).then((result)=>{
      if(result.value){
      var datos = new FormData();
      datos.append("idVisitante", idVisitante);
      datos.append("fotoVisitante", fotoVisitante);
      datos.append("documentoVisitante", documentoVisitante);
      $.ajax({
        url:"ajax/visitantes/borrar",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
        }
      });
      window.location="visitantes";
      }
    });
  });
  $(document).on( 'click', ".btnAutorizarIngreso" ,function(){
    var idVisitante = $(this).attr("idVisitante");
    $('#nuevoIdAutorizacion').val(idVisitante);
  });
});