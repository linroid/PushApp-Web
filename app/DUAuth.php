<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 设备授权其他用户
 *
 * @package App
 * @property integer $id
 * @property integer $device_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\DUAuth whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DUAuth whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DUAuth whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DUAuth whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DUAuth whereUpdatedAt($value)
 * @property-read \App\User $user
 * @property-read \App\Device $device
 */
class DUAuth extends Model {
	protected $table = 'auth';
	protected $hidden = ['device_id', 'user_id'];

	public function user() {
		return $this->hasOne('App\User', 'id', 'user_id');
	}
	public function device() {
		return $this->hasOne('App\Device', 'id', 'device_id');
	}
}
