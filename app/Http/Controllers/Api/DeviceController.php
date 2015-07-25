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
use Validator;

class DeviceController extends ApiController {

	public function getCheck() {
		$token = Input::get('token');
		$deviceId = Input::get('device_id');
		if(empty($token)){
			return $this->response->errorBadRequest(Lang::get('errors.illegal_access'));
		}
		/**
		 * @var BindToken $bindToken
		 */
		$bindToken = BindToken::whereValue($token)->where('expire_in', '>', new Carbon())->first();
		if ($bindToken) {
			$device = Device::whereDeviceId($deviceId)->whereUserId($bindToken->user_id)->first();
			if ($device) {
				return $this->response->array($device);
			}
			return $this->response->noContent();
		}
		return $this->response->error(Lang::get("errors.expired_token"), 401);
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
					return $this->response->error($validator->errors(), 400);
				}
				$device = new Device($data);
				$device->token = str_random(64);
				$device->user_id = $bindToken->user_id;
				$device->save();
				$device->user;
			}

			return $this->response->array([
				'device'    => $device->toArray(),
			    'user'      => $device->user()
			]);


		}
		$this->response->error(Lang::get("errors.expired_token"), 401);
	}

}