<?php
/**
 * Created by PhpStorm.
 * User: linroid
 * Date: 7/24/15
 * Time: 16:22
 */

namespace app\Providers;


use App\Device;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Route;
use Dingo\Api\Contract\Auth\Provider;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class DeviceProvider implements Provider {
	public function authenticate(Request $request, Route $route) {
		$token = $request->header('X-Token');
		if (!Device::attempt($token)) {
			throw new UnauthorizedHttpException('Unable to authenticate with supplied username and password.');
		}
	}
}