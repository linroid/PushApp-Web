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
Route::get('/auth/device', [
	'as' => 'qrcode', 'uses' => 'AuthController@getDevice'
]);
Route::get('/auth/callback', 'AuthController@getCallback');
Route::get('/auth/logout', 'AuthController@getLogout');

//for debug only
if (config('app.debug')) {
	Route::get('/auth/debug', function () {
		Auth::loginUsingId(1, true);
		return Redirect::to('/');
	});
	Route::controller('test', 'TestController');
}

Route::controller('/password', 'PasswordController');
Route::controller('/install', 'InstallController');
Route::controller('/device', 'DeviceController');
Route::controller('/push', 'PushController');

Route::group(['prefix' => 'api', 'namespace' => 'Api', 'middleware'=>'token'], function () {
	Route::resource('device', 'DeviceController');
	Route::get('check', 'AuthController@check');
	Route::post('bind', 'AuthController@bind');
	Route::resource('auth', 'AuthController');
	Route::controller('package', 'PackageController');
	Route::resource('push', 'PushController');
});
