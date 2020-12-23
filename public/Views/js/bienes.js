
/*================================================
=            CARGAR LA TABLA DINAMICA            =
================================================*/
$(function(){
  var table = $('.tablaBienes').DataTable({

  "ajax":"ajax/datatable/propiedades",
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
  $(document).on('click', '.btnEditarPropiedad' ,function(){
    var idPropiedad = $(this).attr("idPropiedad");
    var datos = new FormData();
    datos.append("idPropiedad", idPropiedad);
    $.ajax({
      url:"ajax/propiedades/editar",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        $('#editId').val(answer['id']);
        $('#editIdUnidad').val(answer['organization_id']);
        $('#editApartamento').val(answer['apartment']);
        $('#editCoefficienteApartamento').val(answer['apartment_coefficient']);
        $('#editParqueadero').val(answer['parking']);
        $('#editCoefficienteParqueadero').val(answer['parking_coefficient']);
        $('#editCuartoUtil').val(answer['useful_room']);
        $('#editCoefficienteCuartoUtil').val(answer['useful_room_coefficient']);
        $('#editPlacas').val(answer['plates']);
        $('#editMascotas').val(answer['pets']);
        $('#editEstadoCuotaExtra').val(answer['extra_fee_state']);
        $('#editEstadoFactura').val(answer['bill_state']);
        $('#editCobroFijo').val(answer['fixed_fee']);
      }
    })
  });
});
/*==============================================
=            VERIFICACION DE  CODIGO          =
==============================================*/
$(function(){
  $(document).on( 'change', '#nuevoApartamento' ,function(){
    $(".alert").remove();
    var apartamento = $(this).val();
    var unidad = $('#nuevoIdUnidad');
    var datos = new FormData();
    datos.append("numeroPropiedad", apartamento);
    datos.append("IdUnidad", unidad);
    $.ajax({
      url:"ajax/propiedades/check",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (answer) {
            $("#nuevoApartamento").parent().after('<div class="alert alert-warning">Este apartamento ya se encuentra registrado</div>');
            $("#nuevoApartamento").val("");
        }
      }
    })
  });
});
/*==============================================
=            VERIFICACION DE  Apartamento          =
==============================================*/
$(function(){
  $(document).on( 'change', '#editApartamento' ,function(){
    $(".alert").remove();
    var apartamento = $(this).val();
    var unidad = $('#editIdUnidad');
    var datos = new FormData();
    datos.append("numeroPropiedad", apartamento);
    datos.append("IdUnidad", unidad);
    $.ajax({
      url:"ajax/propiedades/check",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (answer) {
            $("#editApartamento").parent().after('<div class="alert alert-warning">Este apartamento ya se encuentra registrado</div>');
            $("#editApartamento").val("");
        }
      }
    })
  });
});
/*==============================================
=            ELIMINAR UNIDAD          =
==============================================*/
$(function(){
  $(document).on( 'click', ".btnBorrarPropiedad" ,function(){
    var idPropiedad = $(this).attr("idPropiedad");
    swal({
      title: '¿Está seguro de borrar la propiedad?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de propiedad'
    }).then((result)=>{
      if(result.value){
      var datos = new FormData();
      datos.append("idPropiedad", idPropiedad);
      $.ajax({
        url:"ajax/propiedades/borrar",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
        }
      });
      window.location="propiedades";
      }
    });
  });
  $(document).on( 'click', ".btnImprimirFactura" ,function(){
    var idPropiedad = $(this).attr("idPropiedad");
    document.forms[idPropiedad].submit();
  });
});