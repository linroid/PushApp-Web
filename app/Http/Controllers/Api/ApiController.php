<?php
/**
 * Created by PhpStorm.
 * User: linroid
 * Date: 7/24/15
 * Time: 16:08
 */

namespace app\Http\Controllers\Api;


use App\Device;
use Config;
use Illuminate\Routing\Controller;
use Session;

class ApiController extends Controller {

	/**
	 * @var Device $device
	 */
	protected $device;

	/**
	 * ApiController constructor.
	 */
	public function __construct() {
//		Config::set('session.driver', 'array');
		Session::setDefaultDriver(NULL);
		$this->device = Device::current();
	}
}