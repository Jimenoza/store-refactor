<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// All routes are for users, not admin
// routes that don't need authentication
Route::post('/login', 'Api\ApiUserController@login');
Route::post('/register', 'Api\ApiUserController@store');
Route::post('/logout', 'Api\ApiUserController@logout')->middleware('auth:sanctum');
// Products
Route::get('/products', 'Api\ApiProductController@index');
Route::get('/products/category/{id}','Api\ApiProductController@filter');
Route::post('/products/search','Api\ApiProductController@search');
Route::get('/products/{id}','Api\ApiProductController@show');
Route::post('/products/comment/{id}','Api\ApiProductController@comment')->middleware('auth:sanctum');
Route::post('/products/reply/{id}','Api\ApiProductController@reply')->middleware('auth:sanctum');;

// Cart
Route::get('/cart','Api\ApiCartController@index');
Route::post('/cart','Api\ApiCartController@create');
Route::post('/cart/{id}','Api\ApiCartController@store');
Route::get('/cart/delete','Api\ApiCartController@destroy');
Route::get('/cart/remove/{id}','Api\ApiCartController@edit');

//orders
// Route::get('/orders','Api\ApiOrderController@index')->middleware('auth:sanctum','token.admin');
Route::get('/orders','Api\ApiOrderController@index')->middleware('auth:sanctum');
Route::get('/orders/{id}','Api\ApiOrderController@show')->middleware('auth:sanctum');

//Routes for admin

Route::group(['middleware' => ['auth:sanctum','token.admin']], function(){
    //Admin - Manejo de cuentas
    Route::post('/admin/new', 'Api\ApiAdminController@store');
    Route::post('/admin/password/check', 'Api\ApiAdminController@checkPassword');
    Route::put('/admin/password/change', 'Api\ApiAdminController@update');
    //Admin - Manejo de Categorías
    Route::get('/admin/category', 'Api\ApiCategoryController@index');
    Route::get('/admin/category/{id}', 'Api\ApiCategoryController@index');
    Route::post('/admin/category', 'Api\ApiCategoryController@store');
    Route::put('/admin/category/{id}', 'Api\ApiCategoryController@update');
    Route::delete('/admin/category/{id}', 'Api\ApiCategoryController@edit');
    //Admin - Manejo de Productos
    Route::get('/admin/product/{id}','Api\ApiProductController@info');// gets product info, without comments and replies
    Route::post('/admin/product','Api\ApiProductController@store');
    Route::put('/admin/product/{id}', 'Api\ApiProductController@edit');
    Route::post('/admin/product/enable/{id}','Api\ApiProductController@update');
    Route::post('/admin/product/disable/{id}','Api\ApiProductController@update');
    // Route::match(['get','post'], '/admin/product/edit/{id}', 'ProductController@editProduct');
    
  });