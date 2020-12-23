/*==============================================
=            Cambiando menu activo            =
==============================================*/
$(function(){
  $(document).on('click','.nav-link',function(){
    $('.nav-link').removeClass("active");
    $(this).addClass("active");
});
  var getRuta = window.location.pathname;

  switch(getRuta) {
    case '/':
        $('#inicio').addClass("active");
        $('#inicioTree').addClass("menu-open");
        break;
    case '/usuarios':
        $('#usuarios').addClass("active");
        break;
    case '/unidades':
        $('#unidades').addClass("active");
        break;
    case '/propiedades':
        $('#propiedades').addClass("active");
        break;
    case '/propietarios':
        $('#propietarios').addClass("active");
        break;
    case '/arrendatarios':
        $('#arrendatarios').addClass("active");
        break;
    case '/encargados':
        $('#encargados').addClass("active");
        break;
    case '/boletines':
        $('#boletines').addClass("active");
        break;
    case '/asambleas':
        $('#asambleas').addClass("active");
        break;
    case '/pagos':
        $('#pagos').addClass("active");
        break;
    case '/facturas':
        $('#facturas').addClass("active");
        break;
    case '/documentos':
        $('#documentos').addClass("active");
        break;
    case '/parametros':
        $('#parametros').addClass("active");
        break;
    case '/facturas':
        $('#facturas').addClass("active");
        break;
    case '/emails':
        $('#emails').addClass("active");
        break;
    case '/reportes':
        $('#reportes').addClass("active");
        break;
    default:
        break;
  }
});
/*==============================================
=            EDITAR USUARIO            =
==============================================*/
$(function(){
  $(document).on('click', '.btnEditarMain' ,function(){
    var idUsuario = $(this).attr("idUsuario");
    var datos = new FormData();
    datos.append("idUsuario", idUsuario);
    $.ajax({
      url:"ajax/usuarios/editarme",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        $('#usernameEditMe').val(answer['username']);
        $('#passwordMe').val(answer['password']);
        $('#lastPhotoMe').val(answer['photo']);
        
        if (answer['photo'] != "") {
          $('#photoEditMe').attr("src",answer['photo']);
        }
        
      }
    })
  });
});
/*==============================================
=            EDITAR USUARIO            =
==============================================*/
$(function(){
  $(document).on('click', '.btnMensajeAdmon' ,function(){
    var idUsuario = $(this).attr("idUsuario");
    var datos = new FormData();
    datos.append("idUsuario", idUsuario);
    $.ajax({
      url:"Ajax/usuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        $('#passwordMessage').val(answer['password']);
        
      }
    })
  });
});