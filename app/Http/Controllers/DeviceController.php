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
use Auth;
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
		$devices = Device::whereUserId(Auth::id())->paginate(24);
		return View::make('device.index')->with('devices', $devices);
	}
	public function getBind() {
		$token = BindToken::obtain(Auth::user());
		return View::make('device.bind')
			->with('token', $token);
	}


}