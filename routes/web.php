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
Route::get('/admin','Web\WebAdminController@loginPage');
Route::post('/admin','Web\WebAdminController@loginAdmin');
Route::get('/logout', 'Web\WebAdminController@logout');
Auth::routes();

Route::group(['middleware' => ['auth','admin']], function(){
  //Admin - Manejo de cuentas
	Route::get('/admin/index','Web\WebAdminController@index');
  	Route::get('/admin/new/admin', 'Web\WebAdminController@create');
  	Route::post('/admin/new/admin', 'Web\WebAdminController@store');
	Route::post('/admin/password/check', 'Web\WebAdminController@checkPassword');
	Route::get('/admin/password/change', 'Web\WebAdminController@configurations');
	Route::post('/admin/password/change', 'Web\WebAdminController@update');
	//Admin - Manejo de Categorías
	// Route::match(['get','post'], '/admin/category/new', 'CategoryController@addCategory');
	Route::get('/admin/category/new', function(){
		return view('admin.categoria.agregarCategoria');
	});
	Route::post('/admin/category/new', 'CategoryController@addCategory');
	Route::get('/admin/category/edit/{id}', 'CategoryController@editCategory');
	Route::post('/admin/category/edit/{id}', 'CategoryController@edit');
	// Route::match(['get','post'], '/admin/category/edit/{id}', 'CategoryController@editCategory');
	Route::get('/admin/category/index', 'CategoryController@indexCategory');
	Route::match(['get','post'], '/admin/category/delete/{id}', 'CategoryController@deleteCategory');
	//Admin - Manejo de Productos
	Route::get('/admin/product/new','Web\WebProductController@create');
	Route::post('/admin/product/new', 'Web\WebProductController@store');
	Route::get('/admin/product/edit/{id}', 'Web\WebProductController@edit');
	Route::post('/admin/product/edit/{id}','Web\WebProductController@update');
	Route::get('/admin/product/index', 'Web\WebProductController@index');
	// Route::match(['get','post'], '/admin/product/edit/{id}', 'ProductController@editProduct');
	Route::match(['get','post'], '/admin/product/delete/{id}', 'Web\WebProductController@disable');
	Route::match(['get','post'], '/admin/product/enable/{id}', 'Web\WebProductController@enable');
  
});
// FrontEnd
Route::get('/','ClientController@index')->name('home');
Route::get('categories/{id}','Web\WebProductController@filter');
Route::get('results','Web\WebProductController@search');
Route::get('product/{id}','Web\WebProductController@show');//<---------------
try{
	Route::post('comment/{id}','Web\WebProductController@comment')->middleware('auth');
	Route::get('reply/{id}','Web\WebProductController@reply')->middleware('auth');;
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
