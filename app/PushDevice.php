<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PushDevice
 *
 * @property integer $id
 * @property string $status
 * @property integer $device_id
 * @property integer $push_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\PushDevice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PushDevice whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PushDevice whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PushDevice wherePushId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PushDevice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PushDevice whereUpdatedAt($value)
 * @property integer $user_id
 * @method static \Illuminate\Database\Query\Builder|\App\PushDevice whereUserId($value)
 * @property-read Device $device
 */
class PushDevice extends Model {
	public function device() {
	    return $this->hasOne('Device', 'id', 'device_id');
	}
}
