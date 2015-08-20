<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\UnauthorizedException;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Token
 *
 * @property integer $id
 * @property string $expire_in
 * @property integer $owner
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\App\Token whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Token whereExpireIn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Token whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Token whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Token whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Token whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Token whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Token whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Token valid()
 * @property string $type
 * @method static \Illuminate\Database\Query\Builder|\App\Token whereOwner($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Token whereType($value)
 */
class Token extends Model
{
	protected $table = 'tokens';
	public static $type_bind = "bind";
	public static $type_device = "device";

	protected $date = ['expire_in'];

	public function scopeValid($query)
	{
		return $query->where('expire_id', '>', new Carbon());
	}

	/**
	 * 获得绑定Token
	 * @return Token
	 */
	public static function obtainBind() {
		if(Auth::guest()) {
			throw new UnauthorizedException(trans('errors.unauthorized'), 401);
		}
		$carbon = Carbon::create();
		$carbon->subMinute(1);
		//如果一分钟内已产生，使用之前的
		$recentToken = Token::where('created_at', '>', $carbon)->first();
		if($recentToken) {
			return $recentToken;
		}
		return static::generate(Auth::id(), 30, static::$type_bind);
	}

	/**
	 * 获得设备安装token
	 * @return Token
	 */
	public static function obtainDevice() {
		if(Device::current()==null) {
			throw new UnauthorizedException(trans('errors.unauthorized'), 401);
		}
		/**
		 * 十分钟内有效
		 */
		return static::generate(Device::current()->id, 10, static::$type_device);

	}
	private static function generate($owner, $minutes, $type){
		$carbon = Carbon::create();
		$carbon->addMinute($minutes);

		$token = new Token();
		$token->value       = static::generateValue();
		$token->expire_in   = $carbon;
		$token->owner       = $owner;
		$token->type        = $type;
		$token->save();
		return $token;
	}
	public static function generateValue() {
		return str_random(64);
	}
}
