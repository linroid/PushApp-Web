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
use App\DUAuth;
use Carbon\Carbon;
use Input;
use Lang;
use Request;
use Response;
use Validator;

class AuthController extends ApiController {
	/**
	 * 检查bindToken是否有效、设备是否已经绑定过
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function check() {
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
	 * 绑定设备,用户尚未绑定用户
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function bind() {
		$token = Input::get('token');
		$data = Input::all();
		/**
		 * @var BindToken $bindToken
		 */
		$bindToken = BindToken::whereValue($token)->where('expire_in', '>', new Carbon())->first();
		if (!$bindToken) {
			return Response::error(Lang::get("errors.expired_token"), 401);
		}
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
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$auths = DUAuth::whereDeviceId($this->device->id)->with('user')->paginate(30);
		return Response::json($auths);
	}

	/**
	 * 授权其他用户
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request) {
		$token = Input::get('token');
		/**
		 * @var BindToken $bindToken
		 */
		$bindToken = BindToken::whereValue($token)
			->where('expire_in', '>', new Carbon())
			->first();

		if (!$bindToken) {
			return Response::error(Lang::get("errors.expired_token"), 401);
		}
		if ($bindToken->user_id == $this->device->user_id) {
			return Response::error(Lang::get('errors.auth_self'), 400);
		}
		$auth = DUAuth::whereDeviceId($this->device->id)->whereUserId($bindToken->user_id)->first();
		if($auth) {
			return Response::error(Lang::get('errors.authed', ['nickname'=>$auth->user->nickname]));
		}
		$auth = new DUAuth();
		$auth->user_id = $bindToken->user_id;
		$auth->device_id = $this->device->id;
		$auth->save();
		$auth->user;
		return Response::json($auth);
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		/**
		 * @var DUAuth $auth
		 */
		$auth = DUAuth::findOrFail($id);
		if($this->device->user_id != $auth->user_id) {
			return Response::error(Lang::get('errors.forbidden', 403));
		}
		$auth->delete();
		return Response::noContent();
	}
}