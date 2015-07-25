<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Package
 *
 * @property integer $id
 * @property string $package_name
 * @property string $app_name
 * @property integer $version_code
 * @property boolean $sdk_level
 * @property integer $user_id
 * @property string $icon
 * @property string $apk
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Package whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Package wherePackageName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Package whereAppName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Package whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Package whereVersionCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Package whereSdkLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Package whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Package whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Package whereApk($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Package whereUpdatedAt($value)
 * @property string $version_name
 * @method static \Illuminate\Database\Query\Builder|\App\Package whereVersionName($value)
 * @property-read \App\User $user
 */
class Package extends Model
{
	public function user(){
		return $this->hasOne('App\User', 'id', 'user_id');
	}
}
