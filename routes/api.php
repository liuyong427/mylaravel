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

Route::get('/Authenticate/test', 'Webapp\AuthenticateController@test');
Route::any('Authenticate/login', 'Webapp\AuthenticateController@login');
Route::any('Authenticate/getUser', 'Webapp\AuthenticateController@getUser');