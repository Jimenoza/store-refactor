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

// Products
Route::get('/products', 'Api\ApiProductController@index');
Route::get('/products/category/{id}','Api\ApiProductController@filter');
Route::post('/products/search','Api\ApiProductController@search');
Route::get('/products/{id}','Api\ApiProductController@show');
