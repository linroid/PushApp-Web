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
use Validator;

class DeviceController extends ApiController {


	public function postBind() {
		$token = Input::get('token');
		$data = Input::all();
		/**
		 * @var BindToken $bindToken
		 */
		$bindToken = BindToken::whereValue($token)->where('expire_in', '>', new Carbon())->first();
		if ($bindToken) {
			$exists = Device::whereDeviceId(Input::get('device_id'))->with('user')->whereUserId($bindToken->user_id)->first();
			if ($exists) {
				$exists->fill($data);
				$exists->save();
				return $this->response->array($exists->toArray());
			}
			$validator = Validator::make($data, Device::rules($bindToken->user_id), Device::messages());
//			$validator->after(function (Validator $validator) {
//			});
			if ($validator->fails()) {
				return $this->response->error($validator->errors(), 400);
			}
			$device = new Device($data);
			$device->token = str_random(64);
			$device->user_id = $bindToken->user_id;
			$device->save();
			$device->user;
			return $this->response->array($device->toArray());

		}
		return $this->response->error('', 401);
	}

}