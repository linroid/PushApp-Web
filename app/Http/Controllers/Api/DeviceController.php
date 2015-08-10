<?php
/**
 * Created by PhpStorm.
 * User: linroid
 * Date: 7/24/15
 * Time: 16:02
 */

namespace app\Http\Controllers\Api;


use App;
use App\BindToken;
use App\Device;
use Carbon\Carbon;
use DB;
use Input;
use Lang;
use Request;
use Response;
use Validator;

class DeviceController extends ApiController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index() {
		$device = Device::current();
		$devices = Device::whereUserId($device->user_id)
			->where('id', '<>', $device->id)
			->paginate(15);

		return Response::json($devices);
	}

	/**
	 * 检查bindToken是否有效、设备是否已经绑定过
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function check() {
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
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request $request
	 * @return Response
	 */
	public function store(Request $request) {
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
			}

			return Response::json([
				'device'    => $device,
				'user'      => $device->user,
			    'token'     => $device->token
			]);


		}
		return Response::error(Lang::get("errors.expired_token"), 401);
	}


	/**
	 * 设备信息更新
	 * Update the specified resource in storage.
	 *
	 * @param  Request $request
	 * @param  int $id
	 * @return Response
	 */
	public function update(Request $request, $id) {
		$device = Device::current();
		if ($device->id != $id) {
			App::abort(403);
		}
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