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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/supervisord/process', 'SupervisordController@process');
    Route::get('/supervisord/process', 'SupervisordController@processList');
    Route::get('/supervisord/process/tail/{processName}', 'SupervisordController@tail');
    Route::get('/supervisord/state', 'SupervisordController@state');
});