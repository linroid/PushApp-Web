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
		$devices = Device::whereUserId(Auth::id())->paginate(15);
		return View::make('device.index')->with('devices', $devices);
	}
	public function getBind() {
		if(Input::has('token')) {
			return \Redirect::away(env('APP_DOWNLOAD_URL', 'http://fir.im/pushapp'));
		}
		$token = BindToken::obtain(Auth::user());
		return View::make('device.bind')
			->with('token', $token);
	}


}