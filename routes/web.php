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

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/documentation', 'SupervisordController@documentation');
Route::get('/config', 'SupervisordConfigController@view');
Route::get('/config/create', 'SupervisordConfigController@create');
Route::post('/config/save', 'SupervisordConfigController@save');
