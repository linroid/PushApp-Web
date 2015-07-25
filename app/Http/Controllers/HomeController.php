<?php
/**
 * Created by PhpStorm.
 * User: linroid
 * Date: 7/22/15
 * Time: 19:15
 */

namespace app\Http\Controllers;

use App\Device;
use Auth;
use Redirect;
use View;


class HomeController extends Controller {

	/**
	 * HomeController constructor.
	 */
	public function __construct() {
		$this->middleware('guest');
	}

	public function getIndex() {
		return View::make('home.welcome');
	}

}