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

Route::get('/user', 'UserController@getUser');
Route::post('/user/grpc', 'UserController@createUserGrpc');
Route::post('/user/http', 'UserController@createUserHttp');
Route::post('/user', 'UserController@createUser');
