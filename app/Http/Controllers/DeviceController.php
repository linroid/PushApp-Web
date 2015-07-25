<?php
/**
 * Created by PhpStorm.
 * User: linroid
 * Date: 7/23/15
 * Time: 22:26
 */

namespace app\Http\Controllers;


use App\BindToken;
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

	}
	public function getBind() {
		$token = BindToken::obtain(Auth::user());
		return View::make('device.bind')
			->with('token', $token);
	}

}