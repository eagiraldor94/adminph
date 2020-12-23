/*================================================
=            CARGAR LA TABLA DINAMICA            =
================================================*/
$(function(){
  var perfilOculto = $('#perfilOculto').val();
  var table = $('.tablaProductos').DataTable({

  "ajax":"Ajax/datatable-productos.ajax.php?perfilOculto="+perfilOculto,
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
=            SUBIR FOTO DEL USUARIO            =
==============================================*/
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
  }else{
    var datosImagen = new FileReader;
    datosImagen.readAsDataURL(imagen);

    $(datosImagen).on("load", function(event){
      var rutaImagen = event.target.result;
      $(".previsualizar").attr("src",rutaImagen);
    })
  }
});
});
/*==============================================
=            EDITAR USUARIO            =
==============================================*/
$(function(){
  $(document).on('click', '.btnEditarProducto' ,function(){
    var idProducto = $(this).attr("idProducto");
    var datos = new FormData();
    datos.append("idProducto", idProducto);
    $.ajax({
      url:"Ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        $('#nameEdit').val(answer['name']);
        $('#codeEdit').val(answer['code']);
        $('#editId').val(answer['id']);
        $('#rolEdit').val(answer['categorie_id']);
        $('#sellPriceEdit').val(answer['sell_price']);
        $('#lastPhoto').val(answer['photo']);
        if (answer['photo'] != "") {
          $('#photoEdit').attr("src",answer['photo']);
        }
        var idCategoria = $('#rolEdit').val();
        var datos2 = new FormData();
        datos2.append("idCategoria", idCategoria);
        $.ajax({
        url:"Ajax/categorias.ajax.php",
        method: "POST",
        data: datos2,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
          $('#rolEdit').html(answer['name']);     
        }
      });
      }
    });
    
  });   
});
/*==============================================
=            VERIFICACION DE NAME          =
==============================================*/
$(function(){
  $(document).on( 'change', '#nameEdit' ,function(){
    $(".alert").remove();
    var name = $(this).val();
    var datos = new FormData();
    datos.append("nameCheck", name);
    $.ajax({
      url:"Ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (answer) {
            $("#nameEdit").parent().after('<div class="alert alert-warning">Este nombre ya se encuentra registrado</div>');
            $("#nameEdit").val("");
        }
      }
    })
  });
});

/*==============================================
=            ELIMINAR PRODUCTO          =
==============================================*/
$(function(){
  $(document).on( 'click', ".btnBorrarProducto" ,function(){
    var idProducto = $(this).attr("idProducto");
    var fotoProducto = $(this).attr("fotoProducto");

    var codigo = $(this).attr("codigo");
    swal({
      title: '¿Está seguro de borrar el producto?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de producto'
    }).then((result)=>{
      if(result.value){
        window.location = "index.php?ruta=productos&idProducto="+idProducto+"&fotoProducto="+fotoProducto+"&producto="+codigo;
      }
    })
  });
});
/*================================================================
=            Capturando categoria para asignar codigo            =
================================================================*/
$(function(){
  $(document).on('change', '#rol' ,function(){
    var idCategoria = $(this).val();
    var datos = new FormData();
    datos.append("idCategoria",idCategoria);
  $.ajax({
    url:"Ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (!answer) {
        var nuevoCodigo = idCategoria+"01";
        }else{
        var nuevoCodigo = Number(answer['code']) + 1;
         
        }
        $('#newCode').val(nuevoCodigo);
               
      }
  })
  });
  
  
});