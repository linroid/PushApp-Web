<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\User;

Route::get('/', 'HomeController@getIndex');
//Route::controller('/auth', 'AuthController');
Route::get('/auth/social', 'AuthController@getSocial');

Route::get('qrcode/{key}/{value}', function() {
	return \Redirect::away(env('APP_DOWNLOAD_URL', 'http://fir.im/pushapp'));
});
Route::get('/auth/callback', 'AuthController@getCallback');
Route::get('/auth/logout', 'AuthController@getLogout');
// Authentication routes...
Route::get('auth/login', 'AuthController@getLogin');
Route::post('auth/login', 'AuthController@postLogin');
// Registration routes...
Route::get('auth/register', 'AuthController@getRegister');
Route::post('auth/register', 'AuthController@postRegister');

//for debug only
if (config('app.debug')) {
	Route::get('/auth/debug', function () {
		Auth::loginUsingId(1, true);
		return Redirect::to('/');
	});
	Route::controller('test', 'TestController');
}
Route::get('logs', ['uses'=>'\Rap2hpoutre\LaravelLogViewer\LogViewerController@index', 'middleware'=>'admin_only']);

Route::controller('/password', 'PasswordController');
Route::controller('/install', 'InstallController');
Route::controller('/device', 'DeviceController');
Route::controller('/push', 'PushController');

Route::group(['prefix' => 'api', 'namespace' => 'Api', 'middleware'=>'token'], function () {
	Route::get('auth/check', 'AuthController@check');
	Route::post('auth/bind', 'AuthController@bind');
	Route::resource('auth', 'AuthController');
	Route::get('device/token', 'DeviceController@token');
	Route::resource('device', 'DeviceController');
	Route::controller('package', 'PackageController');
	Route::resource('push', 'PushController');
});
