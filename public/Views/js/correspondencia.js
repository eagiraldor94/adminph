
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
  var table = $('.tablaCorrespondencia').DataTable({

  "ajax":"ajax/datatable/correspondencia",
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
  $(document).on( 'change', '#nuevoIdOrganizacion' ,function(){
    $('#nuevoIdPropiedad').children().remove();
    var idUnidad = $(this).val();
    var datos = new FormData();
    datos.append("idUnidad", idUnidad);
    $.ajax({
      url:"/ajax/propiedades/consultar",
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
  $(document).on( 'click', ".btnBorrarCorrespondencia" ,function(){
    var idCorrespondencia = $(this).attr("idCorrespondencia");
    var fotoCorrespondencia = $(this).attr("fotoCorrespondencia");
    swal({
      title: '¿Está seguro de borrar la correspondencia?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de correspondencia'
    }).then((result)=>{
      if(result.value){
      var datos = new FormData();
      datos.append("idCorrespondencia", idCorrespondencia);
      datos.append("fotoCorrespondencia", fotoCorrespondencia);
      $.ajax({
        url:"ajax/correspondencia/borrar",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
        }
      });
      window.location="correspondencia";
      }
    });
  });
  $(document).on( 'click', ".btnEntregarCorrespondencia" ,function(){
    var idCorrespondencia = $(this).attr("idCorrespondencia");
    $('#nuevoIdAutorizacion').val(idCorrespondencia);
  });
});