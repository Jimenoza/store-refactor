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
Route::match(['get','post'],'/admin','AdminController@loginAdmin');
Route::get('/logout', 'AdminController@logout');
Auth::routes();

Route::group(['middleware' => ['auth','admin']], function(){
  //Admin - Manejo de cuentas
	Route::get('/admin/inicio','AdminController@index');
	Route::match(['get', 'post'], '/admin/configuraciones', 'AdminController@configurations');
  Route::match(['get', 'post'], '/admin/crearAdmin', 'AdminController@createAdminUser');
	Route::post('/admin/revisarContrasena', 'AdminController@checkPassword');
	Route::match(['get','post'], '/admin/actualizarContrasena', 'AdminController@updatePassword');
	//Admin - Manejo de Categorías
	Route::match(['get','post'], '/admin/agregarCategoria', 'CategoryController@addCategory');
	Route::get('/admin/indexCategoria', 'CategoryController@indexCategory');
	Route::match(['get','post'], '/admin/editarCategoria/{id}', 'CategoryController@editCategory');
	Route::match(['get','post'], '/admin/eliminarCategoria/{id}', 'CategoryController@deleteCategory');
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

Route::get('/carrito/agregar/{id}','CartController@addItem');
Route::get('/cliente/cart','CartController@seeCart');
Route::get('/carrito/eliminar','CartController@deleteCart');
Route::get('/carrito/quitar/{id}','CartController@removeFromCart');



Route::post('/cliente/inicioSesion', 'ClienteController@inicioSesion');
Route::post('/carrito/pagar', 'CartController@payCart')->middleware('auth');;

Route::get('/cliente/ordenes','OrdenController@verOrdenes')->middleware('auth');
Route::get('/cliente/orden/{id}','OrdenController@verOrden')->middleware('auth');
