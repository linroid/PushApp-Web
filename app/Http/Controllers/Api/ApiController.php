<?php
/**
 * Created by PhpStorm.
 * User: linroid
 * Date: 7/24/15
 * Time: 16:08
 */

namespace app\Http\Controllers\Api;


use Config;
use Illuminate\Routing\Controller;

class ApiController extends Controller {


	/**
	 * ApiController constructor.
	 */
	public function __construct() {
		Config::set('session.driver', 'array');
	}
}