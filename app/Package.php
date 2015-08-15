<?php

namespace App;

use App;
use Auth;
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
 * @property string $path
 * @property-read mixed $download_url
 * @method static \Illuminate\Database\Query\Builder|\App\Package wherePath($value)
 * @property string $md5
 * @method static \Illuminate\Database\Query\Builder|\App\Package whereMd5($value)
 * @property integer $file_size
 * @method static \Illuminate\Database\Query\Builder|\App\Package whereFileSize($value)
 * @property-read mixed $icon_url 
 */
class Package extends Model {
	protected $fillable = ['version_name', 'version_code', 'sdk_level', 'app_name', 'package_name'];
	protected $hidden = ['path', 'md5', 'icon'];
	protected $appends = ['download_url', 'icon_url'];

	public function user() {
		return $this->hasOne('App\User', 'id', 'user_id');
	}

	public function getIconUrlAttribute() {
		return $this->getAssetUrl('icon');
	}

	public function getDownloadUrlAttribute() {
		return $this->getAssetUrl('path');
	}

	private function getAssetUrl($attribute) {
		return url(env('PACKAGE_ROOT')) . '/' . $this->attributes[$attribute];
	}

	/**
	 * 通过参数查找Package
	 * @param $arg mixed 查询参数,可为文件md5或者package id
	 */
	public static function findOrFailFromArg($arg, $user_id) {
		if (is_numeric($arg)) {
			$package = Package::whereUserId($user_id)->findOrFail($arg);
		} else if(is_string($arg)) {
			$package = Package::whereMd5($arg)->orderBy('created_at', 'desc')->firstOrFail();
		} else {
			App::abort(404);
		}
		return $package;
	}
}
