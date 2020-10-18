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
// routes that don't need authentication
Route::post('/login', 'Api\ApiUserController@login');
Route::post('/logout', 'Api\ApiUserController@logout')->middleware('auth:sanctum');
// Products
Route::get('/products', 'Api\ApiProductController@index');
Route::get('/products/category/{id}','Api\ApiProductController@filter');
Route::post('/products/search','Api\ApiProductController@search');
Route::get('/products/{id}','Api\ApiProductController@show');

// Cart
Route::get('/cart','Api\ApiCartController@index');
Route::post('/cart','Api\ApiCartController@create');
Route::post('/cart/{id}','Api\ApiCartController@store');
Route::get('/cart/delete','Api\ApiCartController@destroy');
Route::get('/cart/remove/{id}','Api\ApiCartController@edit');

// routes that need authetication
Route::get('/orders','Api\ApiOrderController@index')->middleware('auth:sanctum','token.admin');
Route::get('/orders/{id}','Api\ApiOrderController@show')->middleware('auth:sanctum');