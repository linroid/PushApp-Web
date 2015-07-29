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
use Request;
use Response;
use Validator;

class DeviceController extends ApiController {
	public function getIndex() {
		$device = Device::current();
		$devices = Device::whereUserId($device->user_id)
			->where('id', '<>', $device->id)
			->paginate(30);
		return Response::json($devices);
	}

	public function getCheck() {
		$token = Input::get('token');
		$deviceId = Input::get('device_id');
		if (empty($token)) {
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
			}
			else {
				$validator = Validator::make($data, Device::create_rules($bindToken->user_id), Device::messages());
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
				'device' => $device,
				'user' => $device
			]);


		}
		return Response::error(Lang::get("errors.expired_token"), 401);
	}

	/**
	 * 设备信息更新
	 */
	public function putIndex() {
		$device = Device::current();
		$data = Request::only(['alias', 'network_type']);

		$validator = Validator::make($data, Device::update_rules($device->user_id), Device::messages());
		if ($validator->fails()) {
			return Response::errors($validator->errors(), 400);
		}
		$device->fill($data);
		$device->save();
		return Response::json($device);
	}
}