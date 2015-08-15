<?php

namespace App;

use HttpResponseException;
use Illuminate\Database\Eloquent\Model;
use JPush\JPushClient;
use JPush\Model as M;
use Lang;
use Mockery\CountValidator\Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
 * @property-read mixed $receiver_count
 */
class Push extends Model {
	protected $appends = ['receiver_count'];

	public function user() {
		return $this->hasOne('App\User', 'id', 'user_id');
	}

	public function package() {
		return $this->hasOne('App\Package', 'id', 'package_id');
	}

	public function getReceiverCountAttribute() {
		return PushDevice::wherePushId($this->attributes['id'])->count();
	}


	public static function send ($devices, Package $package, $user_id) {
		$client = app('JPush\JPushClient');
		$installIds = $devices->pluck('push_id')->toArray();
		if (count($installIds) == 0) {
			throw new \HttpResponseException(Lang::get('errors.device_required'), 400);
		}
		try {
			$result = $client->push()
				->setPlatform(M\all)
				->setAudience(M\registration_id($installIds))
				->setMessage(M\message($package->toJson(), null, "package"))
				->send();
		} catch (\Exception $e) {
			throw new HttpResponseException(Lang::get('errors.push_failed'), 500);
		}

		if ($result->isOk) {
			$push = new Push();
			$push->package_id = $package->id;
			$push->user_id = $user_id;
			$push->sendno = $result->sendno;
			$push->msg_id = $result->msg_id;
			$push->is_ok = $result->isOk;
			$push->save();

			foreach ($devices as $device) {
				$pd = new PushDevice();
				$pd->device_id = $device->id;
				$pd->push_id = $push->id;
				$pd->status = 1;
//				$pd->user_id = Auth::id();
				$pd->save();
			}
			return $push;
		}
		throw new HttpResponseException(Lang::get('errors.push_failed'), 500);
	}
}
