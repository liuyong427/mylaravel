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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout');//get退出登陆

Route::any('/test/{method}', 'TestController@test');
Route::any('/Test/index', 'TestController@index');


Route::group(['namespace'=>'Admin','prefix'=>'Admin','middleware'=>['auth','checkLogin']], function(){
	Route::get('User/getUserlist','UserController@getUserlist');
	Route::get('User','UserController@index');
	Route::get('User/create','UserController@create');
	Route::get('User/edit/{id}','UserController@edit');
	Route::post('User/store','UserController@store');
	Route::post('User/update','UserController@update');
	Route::get('User/destroy/{id}','UserController@destroy');
	Route::post('User/resetPassword','UserController@resetPassword');
	Route::get('User/setEvent','UserController@setEvent');

});

Route::any('Authenticate/login', 'Webapp\AuthenticateController@login');
Route::get('/getUser', 'Webapp\AuthenticateController@getUser');

