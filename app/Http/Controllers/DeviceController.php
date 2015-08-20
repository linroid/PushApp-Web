<?php
/**
 * Created by PhpStorm.
 * User: linroid
 * Date: 7/23/15
 * Time: 22:26
 */

namespace app\Http\Controllers;


use App\BindToken;
use App\Device;
use App\DUAuth;
use App\Token;
use Auth;
use Input;
use View;

class DeviceController extends Controller {

	/**
	 * DeviceController constructor.
	 */
	public function __construct() {
		$this->middleware('auth');
		View::share('active', 'device');
	}

	public function getIndex() {
		$devices = Device::whereUserId(Auth::id())
				->orWhere(function($query) {
					$authed_device_ids = DUAuth::whereUserId(Auth::id())->lists('device_id');
					$query->whereIn('id', $authed_device_ids);
				})->paginate(15);
		return View::make('device.index')->with('devices', $devices);
	}
	public function getBind() {
		$token = Token::obtainBind();
		return View::make('device.bind')
			->with('token', $token);
	}


}