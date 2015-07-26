<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Push
 *
 * @property integer $id
 * @property integer $sendno
 * @property integer $msg_id
 * @property boolean $is_ok
 * @property integer $package_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Push whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Push whereSendno($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Push whereMsgId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Push whereIsOk($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Push wherePackageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Push whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Push whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Push whereUpdatedAt($value)
 * @property-read \App\User $user
 * @property-read \App\Package $package
 */
class Push extends Model {
	public function user() {
		return $this->hasOne('App\User', 'id', 'user_id');
	}

	public function package() {
		return $this->hasOne('App\Package', 'id', 'package_id');
	}
}
