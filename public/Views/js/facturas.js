
/*================================================
=            CARGAR LA TABLA DINAMICA            =
================================================*/
$(function(){
  var table = $('.tablaFacturas').DataTable({

  "ajax":"ajax/datatable/facturas",
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
=            ELIMINAR USUARIO          =
==============================================*/
$(function(){
  $(document).on( 'click', ".btnBorrarFactura" ,function(){
    var idFactura = $(this).attr("idFactura");
    swal({
      title: '¿Está seguro de borrar la factura?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de factura'
    }).then((result)=>{
      if(result.value){
      var datos = new FormData();
      datos.append("idFactura", idFactura);
      $.ajax({
        url:"ajax/facturas/borrar",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
        }
      });
      window.location="facturas";
      }
    });
  });
});
/*==============================================
=           LIMPIAR FACTURAS          =
==============================================*/
$(function(){
  $(document).on( 'click', ".btnFacturasLimpiar" ,function(){
    var idUnidad = $('.unidadLimpiar').val();
    var nombreUnidad = $('.unidadLimpiar').children('option:selected').html();
    swal({
      title: '¿Está seguro de limpiar las facturas del mes de '+nombreUnidad+' ?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar limpieza de facturas'
    }).then((result)=>{
      if(result.value){
      var datos = new FormData();
      datos.append("idUnidad", idUnidad);
      $.ajax({
        url:"ajax/facturas/limpiar",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
        }
      });
      window.location="facturas";
      }
    });
  });
});
/*==============================================
=           LIMPIAR FACTURAS          =
==============================================*/
$(function(){
  $(document).on( 'click', ".btnAplicarFacturas" ,function(){
      $.ajax({
        url:"facturas/aplicar",
        method: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
        }
      });
      window.location="facturas";
});
});