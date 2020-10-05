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
    return redirect('/');
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
	Route::get('/admin/product/new','ProductController@newProductPage');
	Route::post('/admin/product/new', 'ProductController@newProduct');
	Route::get('/admin/product/edit/{id}', 'ProductController@editProductPage');
	Route::post('/admin/product/edit/{id}','ProductController@editProduct');
	Route::get('/admin/product/index', 'ProductController@index');
	// Route::match(['get','post'], '/admin/product/edit/{id}', 'ProductController@editProduct');
	Route::match(['get','post'], '/admin/product/delete/{id}', 'ProductController@removeProduct');
	Route::match(['get','post'], '/admin/product/enable/{id}', 'ProductController@enableProduct');
  
});
// FrontEnd
Route::get('/','ClientController@index')->name('home');
Route::get('categories/{id}','ProductController@filter');
Route::get('results','ProductController@search');
Route::get('product/{id}','ProductController@productDetail');//<---------------
try{
	Route::post('comment/{id}','ProductController@commentProduct')->middleware('auth');
	Route::get('reply/{id}','ProductController@replyComment')->middleware('auth');;
}catch (\Exception $e){
	Route::get('comment/{id}','ClientController@index');
	Route::get('reply/{id}','ClientController@index');
}

Route::group(['middleware'=>['frontLogin']],function(){
  Route::match(['get','post'],'cuenta','UserController@account');
});
Route::get('/login/page','UserController@loginPage');
Route::post('/register','UserController@register');
Route::get('logout','UserController@logout')->middleware('auth');
Route::post('/login', 'UserController@login');


Route::match(['GET','POST'],'/usuarios/chequearEmail','UserController@checkEmail');

Route::match(['GET','POST'],'/usuarios/chequearEmail','UserController@checkEmail');

Route::get('/cart/add/{id}','CartController@addItem');
Route::get('/cart','CartController@seeCart');
Route::get('/cart/delete','CartController@deleteCart');
Route::get('/cart/remove/{id}','CartController@removeFromCart');



Route::post('/purchase', 'OrderController@payOrder')->middleware('auth');;

Route::get('/orders','OrderController@getOrders')->middleware('auth');
Route::get('/order/{id}','OrderController@getOrder')->middleware('auth');
