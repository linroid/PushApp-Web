<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Input;


/**
 * App\Device
 *
 * @property integer $id
 * @property string $model
 * @property string $alias
 * @property string $sdk_level
 * @property string $os_name
 * @property string $height
 * @property string $width
 * @property string $dpi
 * @property string $device_id
 * @property string $memory_size
 * @property string $cpu_type
 * @property string $token
 * @property string $network_type
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereModel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereAlias($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereSdkLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereOsName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereDpi($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereMemorySize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereCpuType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereNetworkType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Device whereUpdatedAt($value)
 */
class Device extends Model {
	private static $device;
	protected $hidden = ['user'];
	protected $fillable = ["model", "alias", "sdk_level", "os_name", "height",
	                       "width", "dpi", "device_id", "memory_size", "cpu_type", "network_type"];

	/**
	 * 获取客户端的Device
	 * @return Device
	 */
	public static function current() {
		return self::$device;
	}

	public static function attempt($token) {
		if (empty($token)) {
			return false;
		}
		$device = Device::whereToken($token)->first();
		self::$device = $device;
		return $device;
	}

	public function user() {
		return $this->hasOne('App\User', 'id', 'user_id');
	}

	public static function rules($user_id) {
		return [
			'device_id' => 'required',
			'token' => 'exists:bind_tokens,value',
			'alias' => 'required|min:3|unique:devices,alias,NULL,id,user_id,' . $user_id
		];
	}

	public static function messages() {
		return [
			'alias.unique' => "已经有设备叫这个了\n换一个呗:)"
		];
	}
}
