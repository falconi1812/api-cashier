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
    return view('welcome');
});

Route::get('/clients/{date?}', 'ClientsController@getAllForToday');

Route::get('/icons', 'IconsController@getAll');

Route::get('/locations/{location_code}', 'LocationsController@getLocation');
Route::put('/locations/products/{location_code}/{product_id}', 'LocationsController@setItems');
Route::delete('/locations/{location_code}', 'LocationsController@closeLocation');
Route::put('/locations/{location_code}', 'LocationsController@restoreLocation');
Route::get('/locations/trash', 'LocationsController@getDeletedLocations');

Route::get('/payments', 'PaymentsController@readAll');
Route::get('/payments/{location_id}', 'PaymentsController@findBylocation');
Route::put('/payments/{location_id}/{type_id}', 'PaymentsController@savePayment');
Route::delete('/payments/{payment_id}', 'PaymentsController@removePayment');

Route::post('/products', 'ProductsController@create');
Route::get('/products', 'ProductsController@read');
Route::put('/products/{product_id}', 'ProductsController@update');
Route::delete('/products/{product_id}', 'ProductsController@delete');
