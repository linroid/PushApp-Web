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

Route::get('/', 'HomeController@getIndex');
//Route::controller('/auth', 'AuthController');
Route::get('/auth/social', 'AuthController@getSocial');
Route::get('/auth/callback', 'AuthController@getCallback');

//for debug only
if (config('app.debug')) {
	Route::get('/auth/debug', function () {
		Auth::loginUsingId(5, true);
		return Redirect::to('/');
	});
	Route::controller('test', 'TestController');
}

Route::controller('/password', 'PasswordController');
Route::controller('/install', 'InstallController');
Route::controller('/device', 'DeviceController');
Route::controller('/device/api', 'Api\DeviceController');

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
	Route::controller('device', 'DeviceController');
	Route::controller('push', 'PushController');
});