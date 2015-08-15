<?php
/**
 * Created by PhpStorm.
 * User: linroid
 * Date: 8/12/15
 * Time: 00:56
 */

namespace app\Http\Controllers\Api;


use App\BindToken;
use App\Device;
use Carbon\Carbon;
use Input;
use Lang;
use Response;
use Validator;

class AuthController extends ApiController {
	/**
	 * 检查bindToken是否有效、设备是否已经绑定过
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getCheck() {
		$token = Input::get('token');
		$unique_id = Input::get('unique_id');
		if (empty($token)) {
			return Response::error(Lang::get('errors.illegal_access'), 400);
		}
		/**
		 * @var BindToken $bindToken
		 */
		$bindToken = BindToken::whereValue($token)->where('expire_in', '>', new Carbon())->first();
		if ($bindToken) {
			$device = Device::whereUniqueId($unique_id)->whereUserId($bindToken->user_id)->first();
			if ($device) {
				return Response::json($device);
			}
			return Response::noContent();
		}
		return Response::error(Lang::get("errors.expired_token"), 401);
	}

	/**
	 * 绑定设备
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function postBind() {
		$token = Input::get('token');
		$data = Input::all();
		/**
		 * @var BindToken $bindToken
		 */
		$bindToken = BindToken::whereValue($token)->where('expire_in', '>', new Carbon())->first();
		if ($bindToken) {
			$device = Device::whereUniqueId(Input::get('unique_id'))
				->with('user')
				->whereUserId($bindToken->user_id)
				->first();
			if ($device) {
				$device->fill($data);
				$device->save();
			} else {
				$validator = Validator::make($data, Device::create_rules($bindToken->user_id), Device::messages());
				if ($validator->fails()) {
					return Response::errors($validator->errors(), 400);
				}
				$device = new Device($data);
				$device->token = str_random(64);
				$device->user_id = $bindToken->user_id;
				$device->save();
			}

			return Response::json([
				'device'    => $device,
				'user'      => $device->user,
				'token'     => $device->token
			]);


		}
		return Response::error(Lang::get("errors.expired_token"), 401);
	}
}