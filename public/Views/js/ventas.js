/*================================================
=            CARGAR LA TABLA DINAMICA            =
================================================*/
$(function(){
  var codigoPropina;
  var $_GET = {};
  if(document.location.toString().indexOf('?') !== -1) {
      var query = document.location
                     .toString()
                     // get the query string
                     .replace(/^.*?\?/, '')
                     // and remove any existing hash string (thanks, @vrijdenker)
                     .replace(/#.*$/, '')
                     .split('&');

      for(var i=0, l=query.length; i<l; i++) {
         var aux = decodeURIComponent(query[i]).split('=');
         $_GET[aux[0]] = aux[1];
      }
  }
  var table = $('.tablaVentas').DataTable({

  "ajax":"Ajax/datatable-ventas.ajax.php",
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
  var rango = $('#perfilOculto').val();
  var uri = "Ajax/datatable-ventas-admin.ajax.php?perfil="+rango;
  if ($_GET['fechaInicial'] != "" && $_GET['fechaInicial'] != null) {
    uri += "&fechaInicial="+$_GET['fechaInicial'];
  }
  if ($_GET['fechaFinal'] != "" && $_GET['fechaFinal'] != null) {
    uri += "&fechaFinal="+$_GET['fechaFinal'];
  }
  var table1 = $('.tablaVentasAdmin').DataTable({

  "ajax":uri,
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
=            AGREGAR PRODUCTOS A LA VENTA         =
==============================================*/
 $(function(){

  /*================================================
=            CARGAR LA TABLA DINAMICA            =
================================================*/
if (localStorage.getItem('rango') != null) {
  $('span#reportrange').html(localStorage.getItem('rango'));
}else{
  $('span#reportrange').html('<i class="fa fa-calendar"></i> Rango de fecha');
}
  $(".contenedorProductos").on( 'click', "div.agregarProducto" ,function(){
    var idProducto = $(this).attr("idProducto");
    $(this).removeClass("btn-dark agregarProducto");
    $(this).addClass("btn-default");
    var datos = new FormData();
    datos.append("idProducto", idProducto);
    $.ajax({
      url:"Ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(answer){
        var name = answer['name'];
        var stock = answer['stock'];
        var precio = answer['sell_price'];
        if (stock < 1) {
          swal({
            title: "No hay unidades disponibles",
            type: "error",
            confirmButtonText: "¡Cerrar!"
          });

          $("div[idProducto='"+idProducto+"']").removeClass("btn-default");
          $("div[idProducto='"+idProducto+"']").addClass("btn-dark agregarProducto");
          return;
        }
        $(".nuevoProducto").append(
          '<div class="row"  style="padding: 0px 8px">'+
              '<div class="col-sm-6">'+
                  '<div class="input-group mb-3">'+
                  '<div class="input-group-prepend">'+
                    '<button type="button" class="btn btn-danger btn-sm quitarProducto input-group-text" idProducto="'+idProducto+'">'+
                    '<i class="fa fa-times">'+
                    '</i>'+
                    '</button>'+
                  '</div>'+
                  '<input type="text" class="form-control agregarProducto nuevaDescripcionProducto" name="newProduct" idProducto="'+idProducto+'" value="'+name+'" required readonly>'+
                  
                  '</div>'+
                '</div>'+
                '<div class="col-sm-2 mb-3">'+
                  
                  '<input type="number" class="form-control nuevaCantidadProducto" name="newQuantity" min="1" max="'+stock+'" stock="'+stock+'" newStock="'+(stock-1)+'" placeholder="Cantidad" value="1" required>'+
               '</div>'+
                '<div class="col-sm-4 ingresoPrecio">'+
                  '<div class="input-group mb-3">'+
                    '<div class="input-group-prepend">'+
                    '<span class="input-group-text">'+
                    '<i class="ion ion-social-usd">'+
                    '</i>'+
                    '</span>'+
                    '</div>'+
                    '<input type="text" class="form-control nuevaPrecioProducto" precioBase="'+precio+'" name="newPrice" value="'+precio+'" readonly required>'+
                  
                  '</div>'+
                '</div>'+
                '</div>'
                )
        sumarTotalPrecios();
        listarProductos();
        $('.nuevaPrecioProducto').number( true, 2 );
      }
    })
  });
/*==============================================
=            QUITAR PRODUCTOS A LA VENTA         =
==============================================*/
/*==============================================
=            CUANDO CARGUE LA TABLA         =
==============================================*/
$(".contenedorProductos").on("change",function(){
  if(localStorage.getItem("quitarProducto") != null){
    var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));
    for (var i = 0; i < listaIdProductos.length; i++) {
      $("div.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-default');

      $("div.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-dark agregarProducto');
    }
  }
});
$(".contenedorProductos").ready(function(){
  if(localStorage.getItem("quitarProducto") != null){
    var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));
    for (var i = 0; i < listaIdProductos.length; i++) {
      $("div.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-default');

      $("div.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-dark agregarProducto');
    }
  }
});
var idQuitarProducto = [];
localStorage.removeItem("quitarProducto");

  $(".formularioVenta").on( 'click', "button.quitarProducto" ,function(){
    var idProducto = $(this).attr('idProducto');
    /*=============================================================================
    =            ALMACENAR EL ID DEL PRODUCTO A QUITAR EN LOCALSTORAGE            =
    =============================================================================*/
    if (localStorage.getItem("quitarProducto") == null) {
      idQuitarProducto = [];
    }else{
      idQuitarProducto.concat(localStorage.getItem("quitarProducto"));
    }
    idQuitarProducto.push({"idProducto":idProducto});
    localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));
    $(this).parent().parent().parent().parent().remove();
    $("div.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');
    $("div.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-dark agregarProducto');
    if ($('.nuevoProducto').children().length == 0) {
      $('#nuevoTotalVenta').val(0);
      $('#totalVenta').val(0);
      $('#nuevoSubTotalVenta').val(0);
      $('#nuevoNetoVenta').val(0);
      $('#netoVenta').val(0);

    }else{
      sumarTotalPrecios();
      listarProductos();  
    }
    
  });
  /*==============================================
=           AGREGAR PRODUCTOS VERSION MOVIL       =
==============================================*/
var numProducto = 0;
  $(document).on("click",".btnAgregarProducto",function(){
    numProducto++;
    var datos = new FormData();
    datos.append("listarProductos","ok");
    $.ajax({
      url:"Ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(answer){
        $(".nuevoProducto").append(
          '<div class="row"  style="padding: 0px 8px">'+
              '<div class="col-sm-6">'+
                  '<div class="input-group mb-3">'+
                  '<div class="input-group-prepend">'+
                    '<button type="button" class="btn btn-danger btn-sm quitarProducto input-group-text" idProducto>'+
                    '<i class="fa fa-times">'+
                    '</i>'+
                    '</button>'+
                  '</div>'+
                  '<select class="form-control nuevaDescripcionProducto" name="newProduct" id="producto'+numProducto+'" idProducto required>'+
                    '<option>Seleccione el producto</option>'+
                  '</select>'+
                  '</div>'+
                '</div>'+
                '<div class="col-sm-2 mb-3 ingresoCantidad">'+
                  
                  '<input type="number" class="form-control nuevaCantidadProducto" name="newQuantity" min="1" stock newStock placeholder="Cantidad" value="1" required>'+
               '</div>'+
                '<div class="col-sm-4 ingresoPrecio">'+
                  '<div class="input-group mb-3">'+
                    '<div class="input-group-prepend">'+
                    '<span class="input-group-text">'+
                    '<i class="ion ion-social-usd">'+
                    '</i>'+
                    '</span>'+
                    '</div>'+
                    '<input type="text" class="form-control nuevaPrecioProducto" precioBase name="newPrice" readonly required>'+
                  
                  '</div>'+
                '</div>'+
                '</div>'
                );
          answer.forEach(funcionForEach);
          function funcionForEach(item,index){
            if (item.stock > 0) {
               $("#producto"+numProducto).append(
                '<option idProducto="'+item.id+'" value="'+item.name+'">'+item.name+'</option>'
              ) 
             }
             }
           
          }
        });
  });
  /*==============================================
=           SELECCIONAR PRODUCTO         =
==============================================*/
$(".formularioVenta").on( 'change', "select.nuevaDescripcionProducto" ,function(){
  var nombreProducto = $(this).val();
  var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevaPrecioProducto");
  var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto");
  datos = new FormData();
  datos.append("nombreProducto",nombreProducto);
    $.ajax({
      url:"Ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(answer){
          $(nuevaCantidadProducto).attr("stock", answer['stock']);
          $(nuevaCantidadProducto).attr("max", answer['stock']);
          $(nuevaCantidadProducto).attr("newStock", (answer['stock']-1));
          $(nuevoPrecioProducto).attr("value", answer['sell_price']);
          $(nuevoPrecioProducto).attr("precioBase", answer['sell_price']);
            sumarTotalPrecios();
            listarProductos();

          $('.nuevaPrecioProducto').number( true, 2 );
      }
    });


  });
  /*==============================================
=           MODIFICAR LA CANTIDAD         =
==============================================*/
  $(".formularioVenta").on( 'change', "input.nuevaCantidadProducto" ,function(){
    var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevaPrecioProducto");
    var precioFinal = $(this).val() * precio.attr("precioBase");
    precio.val(precioFinal);
    var nuevoStock = Number($(this).attr("stock")) - $(this).val();
    $(this).attr("newStock",nuevoStock);
    if (Number($(this).val()) > Number($(this).attr("stock")) ) {
            $(this).val(1);
            precio.val(precio.attr("precioBase"));
      swal({
            title: "La cantidad supera las unidades disponibles",
            text: "¡Sólo hay "+$(this).attr("stock")+" unidades disponibles!",
            type: "error",
            confirmButtonText: "¡Cerrar!"
          });
    }

    sumarTotalPrecios();
    listarProductos();

   });
  $(".formularioVenta").on( 'change', "input#nuevoDescuentoVenta" ,function(){
    agregarDescuento();

   });
  $(".formularioVenta").on( 'change', "input#nuevoImpuestoVenta" ,function(){
    agregarImpuesto();

   });
  /*==============================================
=           Agregando la propina         =
==============================================*/
  $('input[type=radio][name=tipRadio]').change(function(){
      var tipoPropina = $('input[type=radio][name=tipRadio]:checked').attr('id');
      switch (tipoPropina){
        case 'porcentTip':
          $('#valorPropina').attr('readonly','readonly');
          $('#porcentajePropina').removeAttr('readonly');
          $('#tipType').val('porcentual');
          $('#tipValue').val('0');
          $('#valorPropina').val('');
          agregarPropina();
        break;
        case 'customTip':
          $('#valorPropina').removeAttr('readonly');
          $('#porcentajePropina').attr('readonly','readonly');
          $('#tipType').val('personalizada');
          $('#tipValue').val('0');
          $('#porcentajePropina').val('');
          agregarPropina();
        break;
        default:
          $('#valorPropina').attr('readonly','readonly');
          $('#porcentajePropina').attr('readonly','readonly');
          $('#tipType').val('sin propina');
          $('#tipValue').val('0');
          $('#porcentajePropina').val('');
          $('#valorPropina').val('');
          agregarPropina();

        break;
      }
  });
  $(".formularioVenta").on( 'change', "input#valorPropina" ,function(){
    var valorPropina = $(this).val();
    $(this).number(true,2);
    $('#tipValue').val(valorPropina);
    agregarPropina();
 });
  $(".formularioVenta").on( 'change', "input#porcentajePropina" ,function(){
    var valorPropina = $(this).val();
    $('#tipValue').val(valorPropina);
    agregarPropina();
 });
  /*==============================================
=           SUMAR VALOR DE TODOS LOS ITEMS         =
==============================================*/
function sumarTotalPrecios(){
    var precioItem = $(".nuevaPrecioProducto");
    var arraySumaPrecio =[];
    for (var i = 0; i < precioItem.length; i++) {
      arraySumaPrecio.push(Number($(precioItem[i]).val()));
    }
    function sumaArrayPrecios(total,numero){
      return total + numero;
    }
    var sumarTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
    $('#nuevoSubTotalVenta').val(sumarTotalPrecio);
    $('#nuevoSubTotalVenta').number( true, 2 );
    agregarDescuento();
  }
  function agregarDescuento(){
    var dto = $('#nuevoDescuentoVenta').val();
    var subTot = $('#nuevoSubTotalVenta').val();
    var neto = Number(subTot)-(Number(dto)/100)*Number(subTot);
    $('#nuevoNetoVenta').val(neto);
    $('#netoVenta').val(neto);
    $('#nuevoNetoVenta').number( true, 2 );
    agregarImpuesto();
    agregarPropina();
  }
function agregarImpuesto(){
  var impuesto = $('#nuevoImpuestoVenta').val();
  var precioTotal = $('#nuevoNetoVenta').val();
  var precioImpuesto = (Number(impuesto)/100)*Number(precioTotal)+Number(precioTotal);
  $('#nuevoTotalVenta').val(precioImpuesto);
  $('#totalVenta').val(precioImpuesto);
  $('#newTaxValue').val(Number(impuesto)/100*Number(precioTotal));

  $('#nuevoTotalVenta').number( true, 2 );
}
function agregarPropina(){
  var neto = $('#netoVenta').val();
  var tipoPropina = $('#tipType').val();
  var valorPropina = $('#tipValue').val();
  var preTotal = $('#totalVenta').val();
  switch(tipoPropina){
    case 'porcentual':
      var propina = Number(valorPropina)/100*Number(neto);
    break;
    case 'personalizada':
      var propina = valorPropina;
    break;
    default:
      var propina = 0
    break;
  }
  var total = Number(preTotal) + Number(propina);
  $('#nuevoTotalVenta').val(total);
  $('#nuevoTotalVenta').number( true, 2 );
}
  /*==============================================
=          SELECCIONAR METODO DE PAGO         =
==============================================*/
  $(".formularioVenta").on( 'change', "#nuevoMetodoPago" ,function(){
    var metodo = $(this).val();
    switch(metodo) {
    case 'Efectivo':
        $(this).parent().parent().removeClass('col-6');

        $(this).parent().parent().addClass('col-4');
        $(this).parent().parent().parent().children('.cajasMetodoPago').addClass('col-8');
        $(this).parent().parent().parent().children('.cajasMetodoPago').html(
        '<div class="form-group ml-3" style="width:40%">'+
                  '<div class="input-group mb-3">'+
                      '<div class="input-group-prepend d-none d-md-inline-flex">'+
                      '<span class="input-group-text"><i class="ion ion-social-usd"></i></span>'+
                      '</div>'+
                     ' <input type="text" class="form-control nuevoValorEfectivo" placeholder="0" required>'+
                            
                    '</div>'+
                 '</div>'+
                 '<div class="form-group capturarCambioEfectivo ml-3" style="width:40%">'+
                  '<div class="input-group mb-3">'+
                      '<div class="input-group-prepend d-none d-md-inline-flex">'+
                      '<span class="input-group-text"><i class="ion ion-social-usd"></i></span>'+
                      '</div>'+
                     ' <input type="text" class="form-control nuevoCambioEfectivo" placeholder="0" readonly required>'+
                            
                    '</div>'+
                 '</div>'
                );
      $('.nuevoValorEfectivo').number( true, 2 );
      $('.nuevoCambioEfectivo').number( true, 2 );
      break;
    case 'TC':
        $(this).parent().parent().removeClass('col-4');

        $(this).parent().parent().addClass('col-6');
        $(this).parent().parent().parent().children('.cajasMetodoPago').removeClass('col-8');
        $(this).parent().parent().parent().children('.cajasMetodoPago').addClass('col-6');
        $(this).parent().parent().parent().children('.cajasMetodoPago').html(
        '<div class="form-group" style="width:100%">'+
                  '<div class="input-group mb-3">'+
                      '<div class="input-group-prepend d-none d-md-inline-flex">'+
                      '<span class="input-group-text"><i class="fa fa-lock"></i></span>'+
                      '</div>'+
                     ' <input type="text" class="form-control" id="nuevoCodigoTransaccion" name="newTransactionCode" placeholder="Codigo transacción" required>'+
                            
                    '</div>'+
                 '</div>'
                );
      $('.nuevoValorEfectivo').number( true, 2 );
      $('.nuevoCambioEfectivo').number( true, 2 );
        break;
    case 'TD':
        $(this).parent().parent().removeClass('col-4');

        $(this).parent().parent().addClass('col-6');
        $(this).parent().parent().parent().children('.cajasMetodoPago').removeClass('col-8');
        $(this).parent().parent().parent().children('.cajasMetodoPago').addClass('col-6');
        $(this).parent().parent().parent().children('.cajasMetodoPago').html(
        '<div class="form-group" style="width:100%">'+
                  '<div class="input-group mb-3">'+
                      '<div class="input-group-prepend d-none d-md-inline-flex">'+
                      '<span class="input-group-text"><i class="fa fa-lock"></i></span>'+
                      '</div>'+
                     ' <input type="text" class="form-control" id="nuevoCodigoTransaccion" name="newTransactionCode" placeholder="Codigo transacción" required>'+
                            
                    '</div>'+
                 '</div>'
                );
      $('.nuevoValorEfectivo').number( true, 2 );
      $('.nuevoCambioEfectivo').number( true, 2 );
        break;
    case 'TB':
        $(this).parent().parent().removeClass('col-4');

        $(this).parent().parent().addClass('col-6');
        $(this).parent().parent().parent().children('.cajasMetodoPago').removeClass('col-8');
        $(this).parent().parent().parent().children('.cajasMetodoPago').addClass('col-6');
        $(this).parent().parent().parent().children('.cajasMetodoPago').html(
        '<div class="form-group" style="width:100%">'+
                  '<div class="input-group mb-3">'+
                      '<div class="input-group-prepend d-none d-md-inline-flex">'+
                      '<span class="input-group-text"><i class="fa fa-lock"></i></span>'+
                      '</div>'+
                     ' <input type="text" class="form-control" id="nuevoCodigoTransaccion" name="newTransactionCode" placeholder="Codigo transacción" required>'+
                            
                    '</div>'+
                 '</div>'
                );
      $('.nuevoValorEfectivo').number( true, 2 );
      $('.nuevoCambioEfectivo').number( true, 2 );
        break;
   
    default:
        $(this).parent().parent().removeClass('col-4');

        $(this).parent().parent().addClass('col-6');
        $(this).parent().parent().parent().children('.cajasMetodoPago').removeClass('col-8');
        $(this).parent().parent().parent().children('.cajasMetodoPago').addClass('col-6');
        $(this).parent().parent().parent().children('.cajasMetodoPago').html('');
        break;
  }

   });
 $(".formularioVenta").on( 'change', "input.nuevoValorEfectivo" ,function(){
    var efectivo = $(this).val();
    var cambio = Number(efectivo) - Number($('#nuevoTotalVenta').val());
    var nuevoCambioEfectivo = $(this).parent().parent().parent().children('.capturarCambioEfectivo').children().children('.nuevoCambioEfectivo');
    console
    nuevoCambioEfectivo.val(cambio);
 });
   /*==============================================
=          LISTAR PRODUCTOS EN JSON         =
==============================================*/
function listarProductos(){
  var listaProductos = [];
  var name = $('.nuevaDescripcionProducto');
  var quantity = $('.nuevaCantidadProducto');
  var price = $('.nuevaPrecioProducto');
  for (var i = 0; i < name.length; i++) {
    listaProductos.push({"id":$(name[i]).attr("idProducto"),
                        "name":$(name[i]).val(),
                        "quantity":$(quantity[i]).val(),
                        "stock":$(quantity[i]).attr("newStock"),
                        "price":$(price[i]).attr("precioBase"),
                        "total":$(price[i]).val()})
  }
  $('#productList').val(JSON.stringify(listaProductos));
}
/*==============================================
=            ELIMINAR VENTA          =
==============================================*/
$(document).on( 'click', ".btnBorrarVenta" ,function(){
    var idVenta = $(this).attr("idVenta");
    swal({
      title: '¿Está seguro de borrar la venta?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de venta'
    }).then((result)=>{
      if(result.value){
        window.location = "index.php?ruta=ventas-administrar&idVenta="+idVenta;
      }
    })
  });
/*==============================================
=            EDITAR VENTA          =
==============================================*/
$(document).on( 'click', ".btnEditarVenta" ,function(){
    var idVenta = $(this).attr("idVenta");
    
     
  window.location = "index.php?ruta=ventas-editar&idVenta="+idVenta;
    
    
  });
var getRuta2 = window.location.pathname;
if (getRuta2 = "/pos-restaurante/ventas-editar") {
    $('#nuevoTotalVenta').number( true, 2 );
    $('#nuevoNetoVenta').number( true, 2 );
    $('#nuevoSubTotalVenta').number( true, 2 );
    $('.nuevaPrecioProducto').number( true, 2 );
    listarProductos();
}
/*==============================================
=            IMPRIMIR FACTURA         =
==============================================*/
$('.tablaVentasAdmin').on('click','.btnImprimirFactura',function(){
  var codigoVenta = $(this).attr("idVenta");
  window.open("Extentions/tcpdf/pdf/facturas.php?idVenta="+codigoVenta,"_blank");
});
/*==============================================
=            IMPRIMIR FACTURA         =
==============================================*/
$('.tablaVentasAdmin').on('click','.btnImprimirFacturaTermica',function(){
  var codigoVenta = $(this).attr("idVenta");
  var datos = new FormData();
  datos.append("codigoVenta", codigoVenta);
  $.ajax({
    url:"Ajax/ventas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success:function(){}
  })
});
/*==============================================
=            Rango de fechas         =
==============================================*/
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Hoy'       : [moment(), moment()],
          'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Últimos 7 dias' : [moment().subtract(6, 'days'), moment()],
          'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
          'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
          'El mes pasado'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate  : moment(),
        "locale": {
          closeText: 'Cerrar',
       prevText: '< Ant',
       nextText: 'Sig >',
       currentText: 'Hoy',
       monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
       dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
       dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
       dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        "daysOfWeek": ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
       weekHeader: 'Sm',
       dateFormat: 'dd/mm/yy',
       firstDay: 1,
       isRTL: false,
       showMonthAfterYear: false,
       yearSuffix: ''
        }
      },
      function (start, end) {
        $('span#reportrange').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        var fechaInicial = start.format('YYYY-MM-DD');
        var fechaFinal = end.format('YYYY-MM-DD');
        var rango = $('span#reportrange').html();
        localStorage.setItem('rango', rango);
        window.location = "index.php?ruta=ventas-administrar&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
      }
    );
/*==============================================
=           Cancelar rango de fechas         =
==============================================*/
    $('.daterangepicker.opensleft .range_inputs .cancelBtn').on("click", function(){
      localStorage.removeItem('rango');
      localStorage.clear();
      window.location = "ventas-administrar";
    });
/*==============================================
=           Capturar hoy         =
==============================================*/
$('.daterangepicker.opensleft .ranges li').on('click',function(){
  var hoy = $(this).html();
  if (hoy == 'Hoy') {
    var d = new Date();
    var dia = d.getDate();
    var mes = d.getMonth()+1;
    var año = d.getFullYear();
    if (mes <10) {
      var fechaInicial = año+"-0"+mes+"-"+dia;
      var fechaFinal = año+"-0"+mes+"-"+dia;
    }else if (dia < 10) {
      var fechaInicial = año+"-"+mes+"-0"+dia;
      var fechaFinal = año+"-"+mes+"-0"+dia;
    }else if (dia < 10 && mes<10 ) {
      var fechaInicial = año+"-0"+mes+"-0"+dia;
      var fechaFinal = año+"-0"+mes+"-0"+dia; 
    }else{
      var fechaInicial = año+"-"+mes+"-"+dia;
     var fechaFinal = año+"-"+mes+"-"+dia;
    }

    localStorage.setItem('rango', 'Hoy');
    window.location = "index.php?ruta=ventas-administrar&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
  }
});
function quitarAgregarProducto(){
  var idProductos = $('.quitarProducto');
  var botonesTabla = $('div.agregarProducto');
  for (var i = 0; i < idProductos.length; i++) {
    var boton = $(idProductos[i]).attr('idProducto');
    for (var j = 0; j<botonesTabla.length;j++){
      if($(botonesTabla[j]).attr('idProducto')==boton){
        $(botonesTabla[j]).removeClass('btn-dark agregarProducto');
        $(botonesTabla[j]).addClass('btn-default');
      }
    }
  }
}
$('.contenedorProductos').on('change',function(){
    quitarAgregarProducto();
});
/*========================================================
=            Cargando botones segun categoria            =
========================================================*/

$('select#productCategorieSelect').on('change',function(){
    var idCategoria = $(this).val();
     var datos = new FormData();
     var prodPhoto
    datos.append("idCategoriaVenta", idCategoria);
    $(this).parent().parent().children('.contenedorProductos').children().remove();
    $.ajax({
      url:"Ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(answer){
        $(answer).each(function(i,item){
          console.log(item);
          if (item.photo != "" && item.photo != null) {
            prodPhoto = item.photo;
          }else{
            prodPhoto = 'Views/img/productos/default-product.jpg';
          }
          $(".contenedorProductos").append(
          '<div class="col-3 col-lg-4 mb-3"><div class="text-center btn-dark p-1 btn agregarProducto recuperarBoton" idProducto="'+item.id+'"><div class="card-header"><b>'+item.name+'</b></div><img class="card-img-top" src="'+prodPhoto+'" alt="'+item.name+'"></div></div>');
        });
      }
    });
    quitarAgregarProducto();
});
$('.btnAgregarPropina').on('click',function(){
    var tipoPropina = $('#tipType').val();
    if (tipoPropina == "porcentual") {
      var valorPropina = $('#porcentajePropina').val();
    }else if (tipoPropina == "personalizada") {
      var valorPropina = $('#valorPropina').val();
    }else{
      var valorPropina = 0;
    }
     var datos = new FormData();
    datos.append("tipoPropina", tipoPropina);
    datos.append("valorPropina", valorPropina);
    datos.append("codigoPropina", codigoPropina);
    console.log(datos);
    $.ajax({
      url:"Ajax/ventas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(answer){
        console.log(answer);
        if (answer == "ok") {

  window.open("Extentions/tcpdf/pdf/facturas.php?idVenta="+codigoPropina,"_blank");
        }
      }
    });
});
$(document).on("click",'.btnCodigoPropina',(function(){
  codigoPropina = $(this).attr("idVenta");
}));
});
