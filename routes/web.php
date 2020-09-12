<?php
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
Route::get('/', function () {
    return redirect('/cliente/');
});

//Admin - Inicio y Ciere de Sesión
Route::match(['get','post'],'/admin','AdminController@inicioSesion');
Route::get('/logout', 'AdminController@cierreSesion');
Auth::routes();

Route::group(['middleware' => ['auth']], function(){
  //Admin - Manejo de cuentas
	Route::get('/admin/inicio','AdminController@inicio');
	Route::match(['get', 'post'], '/admin/configuraciones', 'AdminController@configuraciones');
  Route::match(['get', 'post'], '/admin/crearAdmin', 'AdminController@crearUsuarioAdministrador');
	Route::post('/admin/revisarContrasena', 'AdminController@revisarContrasena');
	Route::match(['get','post'], '/admin/actualizarContrasena', 'AdminController@actualizarContrasena');
	//Admin - Manejo de Categorías
	Route::match(['get','post'], '/admin/agregarCategoria', 'CategoriaController@agregarCategoria');
	Route::get('/admin/indexCategoria', 'CategoriaController@indexCategoria');
	Route::match(['get','post'], '/admin/editarCategoria/{id}', 'CategoriaController@editarCategoria');
	Route::match(['get','post'], '/admin/eliminarCategoria/{id}', 'CategoriaController@eliminarCategoria');
	//Admin - Manejo de Productos
	Route::match(['get','post'], '/admin/agregarProducto', 'ProductoController@agregarProducto');
	Route::get('/admin/indexProducto', 'ProductoController@indexProducto');
	Route::match(['get','post'], '/admin/editarProducto/{id}', 'ProductoController@editarProducto');
	Route::match(['get','post'], '/admin/eliminarProducto/{id}', 'ProductoController@eliminarProducto');
	Route::match(['get','post'], '/admin/habilitarProducto/{id}', 'ProductoController@habilitarProducto');
  
});
// FrontEnd
Route::get('cliente','ClienteController@index')->name('home');
Route::get('cliente/categories/{id}','ProductoController@filtrar');
Route::get('cliente/results','ProductoController@search');
Route::get('cliente/product/{id}','ProductoController@infoProducto');//<---------------
try{
	Route::post('cliente/comentar/{id}','ProductoController@comentarProducto')->middleware('auth');
	Route::get('cliente/responder/{id}','ProductoController@responderComentario')->middleware('auth');;
}catch (\Exception $e){
	Route::get('cliente/comentar/{id}','ClienteController@index');
	Route::get('cliente/responder/{id}','ClienteController@index');
}

Route::group(['middleware'=>['frontLogin']],function(){
  Route::match(['get','post'],'cuenta','UsuarioController@cuenta');
});
Route::get('/usuarios/inicioSesionRegistro','UsuarioController@inicioSesionRegistro');
Route::post('/usuarios/registrar','UsuarioController@registrar');
Route::get('usuarios/cierreSesion','UsuarioController@cerrarSesion')->middleware('auth');
Route::post('/usuarios/inicioSesion', 'UsuarioController@inicioSesion');


Route::match(['GET','POST'],'/usuarios/chequearEmail','UsuarioController@chequearEmail');

Route::match(['GET','POST'],'/usuarios/chequearEmail','UsuarioController@chequearEmail');

Route::get('/carrito/agregar/{id}','CarritoController@agregarItem');
Route::get('/cliente/cart','CarritoController@verCarrito');
Route::get('/carrito/eliminar','CarritoController@eliminarCarrito');
Route::get('/carrito/quitar/{id}','CarritoController@quitarDelCarrito');



Route::post('/cliente/inicioSesion', 'ClienteController@inicioSesion');
Route::post('/carrito/pagar', 'CarritoController@pagar')->middleware('auth');;

Route::get('/cliente/ordenes','OrdenController@verOrdenes')->middleware('auth');
Route::get('/cliente/orden/{id}','OrdenController@verOrden')->middleware('auth');
