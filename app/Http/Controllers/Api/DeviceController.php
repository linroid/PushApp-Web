<?php
/**
 * Created by PhpStorm.
 * User: linroid
 * Date: 7/24/15
 * Time: 16:02
 */

namespace app\Http\Controllers\Api;


use App\BindToken;
use App\Device;
use Carbon\Carbon;
use Input;
use Lang;
use Response;
use Validator;

class DeviceController extends ApiController {

	public function getCheck() {
		$token = Input::get('token');
		$deviceId = Input::get('device_id');
		if(empty($token)){
			return Response::error(Lang::get('errors.illegal_access'), 400);
		}
		/**
		 * @var BindToken $bindToken
		 */
		$bindToken = BindToken::whereValue($token)->where('expire_in', '>', new Carbon())->first();
		if ($bindToken) {
			$device = Device::whereDeviceId($deviceId)->whereUserId($bindToken->user_id)->first();
			if ($device) {
				return Response::json($device);
			}
			return Response::noContent();
		}
		return Response::error(Lang::get("errors.expired_token"), 401);
	}

	public function postBind() {
		$token = Input::get('token');
		$data = Input::all();
		/**
		 * @var BindToken $bindToken
		 */
		$bindToken = BindToken::whereValue($token)->where('expire_in', '>', new Carbon())->first();
		if ($bindToken) {
			$device = Device::whereDeviceId(Input::get('device_id'))->with('user')->whereUserId($bindToken->user_id)->first();
			if ($device) {
				$device->fill($data);
				$device->save();
			}else {
				$validator = Validator::make($data, Device::rules($bindToken->user_id), Device::messages());
				if ($validator->fails()) {
					return Response::errors($validator->errors(), 400);
				}
				$device = new Device($data);
				$device->token = str_random(64);
				$device->user_id = $bindToken->user_id;
				$device->save();
				$device->user;
			}

			return Response::json([
				'device'    => $device,
			    'user'      => $device
			]);


		}
		return Response::error(Lang::get("errors.expired_token"), 401);
	}

}