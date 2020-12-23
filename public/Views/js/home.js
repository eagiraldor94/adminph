
/*================================================
=            CARGAR LA TABLA DINAMICA            =
================================================*/
$(function(){
  $('.btnMostrarMas').on('click',function(){
    $('.opcionOculta').removeClass('d-none').removeClass('opcionOculta');
    $(this).parent().parent().remove();
  });
});