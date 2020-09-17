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
	Route::match(['get','post'], '/admin/agregarProducto', 'ProductController@newProduct');
	Route::get('/admin/indexProducto', 'ProductController@index');
	Route::match(['get','post'], '/admin/editarProducto/{id}', 'ProductController@editProduct');
	Route::match(['get','post'], '/admin/eliminarProducto/{id}', 'ProductController@removeProduct');
	Route::match(['get','post'], '/admin/habilitarProducto/{id}', 'ProductController@enableProduct');
  
});
// FrontEnd
Route::get('cliente','ClientController@index')->name('home');
Route::get('cliente/categories/{id}','ProductController@filter');
Route::get('cliente/results','ProductController@search');
Route::get('cliente/product/{id}','ProductController@productDetail');//<---------------
try{
	Route::post('cliente/comentar/{id}','ProductController@commentProduct')->middleware('auth');
	Route::get('cliente/responder/{id}','ProductController@replyComment')->middleware('auth');;
}catch (\Exception $e){
	Route::get('cliente/comentar/{id}','ClientController@index');
	Route::get('cliente/responder/{id}','ClientController@index');
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



Route::post('/cliente/inicioSesion', 'ClientController@login');
Route::post('/carrito/pagar', 'CartController@payCart')->middleware('auth');;

Route::get('/cliente/ordenes','OrderController@getOrders')->middleware('auth');
Route::get('/cliente/orden/{id}','OrderController@getOrder')->middleware('auth');
