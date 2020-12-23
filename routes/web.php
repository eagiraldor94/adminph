<?php
use Dacastro4\LaravelGmail\Services\Message\Mail;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ControladorGeneral@vistaHome');
Route::redirect('inicio','/');

Route::get('test', function(){
	return view('booking.calendartry');
});
Route::get('prueba', 'ControladorGeneral@vistaDias');


Route::post('/', 'ControladorUsuarios@ctrIngresoUsuario');
Route::post('ajax/usuarios/editar','ControladorUsuarios@ajaxEditarUsuario');
Route::post('ajax/usuarios/editarme','ControladorUsuarios@ajaxEditarme');
Route::post('ajax/usuarios/activar','ControladorUsuarios@ajaxActivarUsuario');
Route::post('ajax/usuarios/check','ControladorUsuarios@ajaxCheckearUsuario');
Route::post('ajax/usuarios/borrar','ControladorUsuarios@ctrBorrarUsuario');
Route::post('editarme/{rank}/{id}','ControladorUsuarios@ctrEditarme');
Route::post('info/{rank}/{id}','ControladorUsuarios@ctrInfo');
Route::post('mensaje/{rank}/{id}','ControladorUsuarios@ctrMensaje');
Route::get('usuarios','ControladorGeneral@vistaUsuarios');
Route::post('usuarios', 'ControladorUsuarios@ctrCrearUsuario');
Route::post('usuarios/editar', 'ControladorUsuarios@ctrEditarUsuario');
Route::get('salir','ControladorUsuarios@ctrSacarUsuario');

Route::post('ajax/unidades/editar','ControladorUnidades@ajaxEditarUnidad');
Route::post('ajax/unidades/check','ControladorUnidades@ajaxCheckearUnidad');
Route::post('ajax/unidades/borrar','ControladorUnidades@ctrBorrarUnidad');
Route::get('unidades','ControladorGeneral@vistaUnidades');
Route::post('unidades', 'ControladorUnidades@ctrCrearUnidad');
Route::post('unidades/editar', 'ControladorUnidades@ctrEditarUnidad');

// Route::post('ajax/conceptos/editar','ControladorConceptos@ajaxEditarConcepto');
// Route::post('ajax/conceptos/borrar','ControladorConceptos@ctrBorrarConcepto');
// Route::get('conceptos','ControladorGeneral@vistaConceptos');
// Route::post('conceptos', 'ControladorConceptos@ctrCrearConcepto');
// Route::post('conceptos/editar', 'ControladorConceptos@ctrEditarConcepto');
// Route::post('ajax/conceptos/check','ControladorConceptos@ajaxCheckearConcepto');

Route::post('ajax/propiedades/editar','ControladorPropiedades@ajaxEditarPropiedad');
Route::post('ajax/propiedades/borrar','ControladorPropiedades@ctrBorrarPropiedad');
Route::get('propiedades','ControladorGeneral@vistaPropiedades');
Route::post('propiedades', 'ControladorPropiedades@ctrCrearPropiedad');
Route::post('propiedades/subir', 'ControladorPropiedades@ctrSubirPropiedades');
Route::post('propiedades/editar', 'ControladorPropiedades@ctrEditarPropiedad');
Route::post('ajax/propiedades/check','ControladorPropiedades@ajaxCheckearPropiedad');
Route::post('ajax/propiedades/consultar','ControladorPropiedades@ajaxConsultarPropiedades');
Route::get('ajax/datatable/propiedades','ControladorPropiedades@ajaxDatatablePropiedades');

Route::post('ajax/propietarios/editar','ControladorPropietarios@ajaxEditarPropietario');
Route::post('ajax/propietarios/activar','ControladorPropietarios@ajaxActivarPropietario');
Route::post('ajax/propietarios/check','ControladorPropietarios@ajaxCheckearPropietario');
Route::post('ajax/propietarios/borrar','ControladorPropietarios@ctrBorrarPropietario');
Route::get('propietarios','ControladorGeneral@vistaPropietarios');
Route::post('propietarios', 'ControladorPropietarios@ctrCrearPropietario');
Route::post('propietarios/editar', 'ControladorPropietarios@ctrEditarPropietario');
Route::post('propietarios/subir', 'ControladorPropietarios@ctrSubirPropietarios');
Route::get('ajax/datatable/propietarios','ControladorPropietarios@ajaxDatatablePropietarios');

Route::post('ajax/arrendatarios/editar','ControladorArrendatarios@ajaxEditarArrendatario');
Route::post('ajax/arrendatarios/activar','ControladorArrendatarios@ajaxActivarArrendatario');
Route::post('ajax/arrendatarios/check','ControladorArrendatarios@ajaxCheckearArrendatario');
Route::post('ajax/arrendatarios/borrar','ControladorArrendatarios@ctrBorrarArrendatario');
Route::get('arrendatarios','ControladorGeneral@vistaArrendatarios');
Route::post('arrendatarios', 'ControladorArrendatarios@ctrCrearArrendatario');
Route::post('arrendatarios/editar', 'ControladorArrendatarios@ctrEditarArrendatario');
Route::get('ajax/datatable/arrendatarios','ControladorArrendatarios@ajaxDatatableArrendatarios');

Route::post('ajax/encargados/editar','ControladorEncargados@ajaxEditarEncargado');
Route::post('ajax/encargados/activar','ControladorEncargados@ajaxActivarEncargado');
Route::post('ajax/encargados/check','ControladorEncargados@ajaxCheckearEncargado');
Route::post('ajax/encargados/borrar','ControladorEncargados@ctrBorrarEncargado');
Route::get('encargados','ControladorGeneral@vistaEncargados');
Route::post('encargados', 'ControladorEncargados@ctrCrearEncargado');
Route::post('encargados/editar', 'ControladorEncargados@ctrEditarEncargado');
Route::get('ajax/datatable/encargados','ControladorEncargados@ajaxDatatableEncargados');

Route::post('ajax/boletines/editar','ControladorBoletines@ajaxEditarBoletin');
Route::post('ajax/boletines/borrar','ControladorBoletines@ctrBorrarBoletin');
Route::get('boletines','ControladorGeneral@vistaBoletines');
Route::post('boletines', 'ControladorBoletines@ctrCrearBoletin');
Route::post('boletines/editar', 'ControladorBoletines@ctrEditarBoletin');
Route::get('ajax/datatable/boletines','ControladorBoletines@ajaxDatatableBoletines');

Route::post('ajax/asambleas/editar','ControladorAsambleas@ajaxEditarAsamblea');
Route::post('ajax/asambleas/borrar','ControladorAsambleas@ctrBorrarAsamblea');
Route::get('asambleas','ControladorGeneral@vistaAsambleas');
Route::post('asambleas', 'ControladorAsambleas@ctrCrearAsamblea');
Route::post('asambleas/editar', 'ControladorAsambleas@ctrEditarAsamblea');
Route::get('ajax/datatable/asambleas','ControladorAsambleas@ajaxDatatableAsambleas');

Route::post('ajax/pagos/editar','ControladorPagos@ajaxEditarPago');
Route::post('ajax/pagos/borrar','ControladorPagos@ctrBorrarPago');
Route::get('pagos','ControladorGeneral@vistaPagos');
Route::post('pagos', 'ControladorPagos@ctrCrearPago');
Route::post('pagos/editar', 'ControladorPagos@ctrEditarPago');
Route::post('pagos/subir', 'ControladorPagos@ctrSubirPagos');
Route::post('pagos/antiguos/subir', 'ControladorPagos@ctrPagosViejos');
Route::get('ajax/datatable/pagos','ControladorPagos@ajaxDatatablePagos');

Route::post('ajax/gastos/borrar','ControladorGastos@ctrBorrarGasto');
Route::get('gastos','ControladorGeneral@vistaGastos');
Route::post('gastos', 'ControladorGastos@ctrCrearGasto');
Route::get('ajax/datatable/gastos','ControladorGastos@ajaxDatatableGastos');

Route::post('ajax/minutas/borrar','ControladorMinutas@ctrBorrarMinuta');
Route::get('minutas','ControladorGeneral@vistaMinutas');
Route::post('minutas', 'ControladorMinutas@ctrCrearMinuta');
Route::get('ajax/datatable/minutas','ControladorMinutas@ajaxDatatableMinutas');

Route::post('ajax/visitantes/borrar','ControladorVisitantes@ctrBorrarVisitante');
Route::get('visitantes','ControladorGeneral@vistaVisitantes');
Route::post('visitantes', 'ControladorVisitantes@ctrCrearVisitante');
Route::get('ajax/datatable/visitantes','ControladorVisitantes@ajaxDatatableVisitantes');
Route::post('visitantes/autorizar', 'ControladorVisitantes@ctrAutorizarIngreso');

Route::post('ajax/reportes/borrar','ControladorReportes@ctrBorrarReporte');
Route::get('reportes-danos','ControladorGeneral@vistaReportesDaños');
Route::post('reportes-danos', 'ControladorReportes@ctrCrearReporte');
Route::get('ajax/datatable/reportes','ControladorReportes@ajaxDatatableReportes');
Route::post('reportes/priorizar', 'ControladorReportes@ctrCambiarPrioridad');

Route::post('ajax/clasificados/borrar','ControladorAnuncios@ctrBorrarClasificado');
Route::post('ajax/clasificados/editar','ControladorAnuncios@ajaxEditarClasificado');
Route::get('clasificados','ControladorGeneral@vistaClasificados');
Route::get('clasificados/{page}','ControladorGeneral@vistaClasificadosPagina');
Route::post('clasificados/{page}', 'ControladorAnuncios@ctrCrearClasificado');
Route::get('ajax/datatable/clasificados','ControladorAnuncios@ajaxDatatableClasificados');
Route::post('autorizar-clasificado', 'ControladorAnuncios@ctrAutorizarClasificado');

Route::post('ajax/correspondencia/borrar','ControladorPaquetes@ctrBorrarCorrespondencia');
Route::get('correspondencia','ControladorGeneral@vistaCorrespondencia');
Route::post('correspondencia', 'ControladorPaquetes@ctrCrearCorrespondencia');
Route::get('ajax/datatable/correspondencia','ControladorPaquetes@ajaxDatatableCorrespondencia');
Route::post('correspondencia/entrega', 'ControladorPaquetes@ctrEntregarCorrespondencia');

Route::post('ajax/parametros/editar','ControladorParametros@ajaxConsultarParametro');
Route::post('parametros/editar', 'ControladorParametros@ctrEditarParametro');
Route::post('parametros', 'ControladorParametros@ctrEditarFirma');

Route::post('ajax/facturas/editar','ControladorFacturas@ajaxConsultarFactura');
Route::post('ajax/facturas/borrar','ControladorFacturas@ctrBorrarFactura');
Route::post('ajax/facturas/limpiar','ControladorFacturas@ajaxLimpiarFacturas');
Route::get('facturas','ControladorGeneral@vistaFacturas');
Route::post('facturas', 'ControladorFacturas@ctrCrearFactura');
Route::get('facturas/masa/{id}', 'ControladorFacturas@ctrFacturaMasiva');
Route::post('facturas/subir', 'ControladorFacturas@ctrFacturasViejas');
Route::get('ajax/datatable/facturas','ControladorFacturas@ajaxDatatableFacturas');
Route::post('facturas/aplicar', 'ControladorFacturas@ctrAplicarFacturas');

Route::post('ajax/documentos/editar','ControladorDocumentos@ajaxEditarDocumento');
Route::post('ajax/documentos/borrar','ControladorDocumentos@ctrBorrarDocumento');
Route::get('documentos','ControladorGeneral@vistaDocumentos');
Route::post('documentos', 'ControladorDocumentos@ctrCrearDocumento');
Route::post('documentos/editar', 'ControladorDocumentos@ctrEditarDocumento');
Route::post('documentos/subir', 'ControladorDocumentos@ctrSubirDocumentos');
Route::post('documentos/antiguos/subir', 'ControladorDocumentos@ctrDocumentosViejos');
Route::get('ajax/datatable/documentos','ControladorDocumentos@ajaxDatatableDocumentos');

Route::get('parametros', 'ControladorGeneral@vistaParametros');
Route::get('emails', 'ControladorGeneral@vistaEmails');
Route::get('ajax/datatable/emails','ControladorCorreos@ajaxDatatableCorreos');
Route::get('reportes','ControladorGeneral@vistaReportes');
Route::post('reportes/descargar','ControladorGeneral@enrutadorReportes');

// Route::get('clientes/facturas/prueba','ControladorGeneral@pruebaFactura');
// Route::get('clientes/notas/prueba','ControladorGeneral@pruebaNota');
// Route::get('clientes/recibos/prueba','ControladorGeneral@pruebaRecibo');
Route::get('clientes/notas/{id}','ControladorGeneral@validacionDocumento');
Route::get('clientes/recibos/{id}','ControladorGeneral@vistaRecibo');
Route::get('clientes/facturas/{id}','ControladorGeneral@vistaFactura');
Route::get('pdf/facturas/masa/{id}','ControladorGeneral@facturaMasa');
// Route::get('mail/prueba', 'ControladorGeneral@correoPrueba');
Route::get('/{any}', function ($any) {

return redirect('/');

})->where('any', '.*');