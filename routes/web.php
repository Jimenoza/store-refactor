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
	Route::get('/admin/index','AdminController@index');
	Route::match(['get', 'post'], '/admin/configs', 'AdminController@configurations');
  Route::match(['get', 'post'], '/admin/new/admin', 'AdminController@createAdminUser');
	Route::post('/admin/password/check', 'AdminController@checkPassword');
	Route::match(['get','post'], '/admin/password/change', 'AdminController@updatePassword');
	//Admin - Manejo de Categorías
	Route::match(['get','post'], '/admin/category/new', 'CategoryController@addCategory');
	Route::get('/admin/category/index', 'CategoryController@indexCategory');
	Route::match(['get','post'], '/admin/category/edit/{id}', 'CategoryController@editCategory');
	Route::match(['get','post'], '/admin/category/delete/{id}', 'CategoryController@deleteCategory');
	//Admin - Manejo de Productos
	Route::match(['get','post'], '/admin/product/new', 'ProductController@newProduct');
	Route::get('/admin/product/index', 'ProductController@index');
	Route::match(['get','post'], '/admin/product/edit/{id}', 'ProductController@editProduct');
	Route::match(['get','post'], '/admin/product/delete/{id}', 'ProductController@removeProduct');
	Route::match(['get','post'], '/admin/product/enable/{id}', 'ProductController@enableProduct');
  
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
  Route::match(['get','post'],'cuenta','UserController@account');
});
Route::get('/usuarios/inicioSesionRegistro','UserController@loginPage');
Route::post('/usuarios/registrar','UserController@register');
Route::get('usuarios/cierreSesion','UserController@logout')->middleware('auth');
Route::post('/usuarios/inicioSesion', 'UserController@login');


Route::match(['GET','POST'],'/usuarios/chequearEmail','UserController@checkEmail');

Route::match(['GET','POST'],'/usuarios/chequearEmail','UserController@checkEmail');

Route::get('/carrito/agregar/{id}','CartController@addItem');
Route::get('/cliente/cart','CartController@seeCart');
Route::get('/carrito/eliminar','CartController@deleteCart');
Route::get('/carrito/quitar/{id}','CartController@removeFromCart');



Route::post('/cliente/inicioSesion', 'ClientController@login');
Route::post('/carrito/pagar', 'CartController@payCart')->middleware('auth');;

Route::get('/cliente/ordenes','OrderController@getOrders')->middleware('auth');
Route::get('/cliente/orden/{id}','OrderController@getOrder')->middleware('auth');
