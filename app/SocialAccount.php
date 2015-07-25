<?php

namespace App;

use App;
use Illuminate\Database\Eloquent\Model;

/**
 * App\SocialAccount
 *
 * @property string $token
 * @property string $id
 * @property string $platform
 * @property string $avatar
 * @property string $nickname
 * @property string $homepage
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount wherePlatform($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount whereHomepage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SocialAccount whereUpdatedAt($value)
 * @property-read \App\User $user
 */
class SocialAccount extends Model {
	public static $allowed_platforms = ["github", "weibo"];

	public static function from($info, $platform){
		if(!in_array($platform, SocialAccount::$allowed_platforms)) {
			App::abort(400);
		}
		$social = new SocialAccount();
		$social->id = $info->id;
		$social->avatar = $info->avatar;
		$social->token = $info->token;
		$social->nickname = $info->nickname;
		$social->platform = $platform;
		switch ($platform) {
			case 'github':
				$social->homepage = $info->user['html_url'];
				break;
			case 'weibo':
				$social->homepage = 'http://weibo.com/u/'.$info->id;
				break;
		}
		return $social;
	}
	public function user(){
		return $this->hasOne('App\User', 'id', 'user_id');
	}
}
