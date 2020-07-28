<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'CartController@index');
Route::post('storecart/{id}', 'CartController@storecart');
Route::get('cart', 'CartController@viewCart');

Route::post('updatequantity/{id}', 'CartController@updatequantity');
Route::delete('removeorder/{id}', 'CartController@removeorder');
Route::post('storeorder/{reference_no}', 'CartController@storeorder');

Route::get('summaryorder/{id}', 'CartController@summaryorder');
Route::delete('neworder/{id}', 'CartController@neworder');


