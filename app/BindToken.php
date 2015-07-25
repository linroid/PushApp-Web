<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\UnauthorizedException;
use Illuminate\Database\Eloquent\Model;

/**
 * App\BindToken
 *
 * @property integer $id
 * @property string $expire_in
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\App\BindToken whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BindToken whereExpireIn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BindToken whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BindToken whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BindToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BindToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BindToken whereToken($value)
 * @property-read \App\User $user 
 * @method static \Illuminate\Database\Query\Builder|\App\BindToken whereValue($value)
 */
class BindToken extends Model
{
	protected $date = ['expire_in'];

	public static function obtain(User $user) {
		if(!$user) {
			throw new UnauthorizedException("user can not be null", 401);
		}
		$carbon = Carbon::create();
		$carbon->subMinute(1);
		//如果一分钟内已产生，使用之前的
		$recentToken = BindToken::where('created_at', '>', $carbon)->first();
		if($recentToken) {
			return $recentToken;
		}
		$carbon = Carbon::create();
		$carbon->addMinute(30);

		$token = new BindToken();
		$token->value  = str_random(64);
		$token->expire_in = $carbon;
		$token->user_id   = $user->id;
		$token->save();
		return $token;
	}
	public static function check

	public function user() {
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

}
