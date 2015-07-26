<?php
/**
 * Created by PhpStorm.
 * User: linroid
 * Date: 7/22/15
 * Time: 19:13
 */

namespace app\Http\Controllers;

use App\Device;
use App\Package;
use Auth;
use File;
use Input;
use JPush\JPushClient;
use JPush\Model as M;
use Redirect;
use Response;
use View;

class InstallController extends Controller {

	/**
	 * InstallController constructor.
	 */
	public function __construct()
	{
		$this->middleware('device_count');
		$this->middleware('auth');
		View::share('active', 'install');
	}

	public function getIndex() {
		return View::make('install.index');
	}

	public function postUpload() {
		$package = $this->parseApk();

		//waring For test

		$client = new JPushClient(env('JPUSH_APP_KEY'), env('JPUSH_APP_SECRET'));
		$result = $client->push()
			->setPlatform(M\all)
			->setAudience(M\all)
			->setNotification(M\notification('Hi, JPush'))
			->send();
		var_dump($result);
		$msg_ids = $result->msg_id;
		$result = $client->report($msg_ids);
		var_dump($result);
//		return Response::json($package);
	}
	private function parseApk() {
		$inputFile = Input::file('file');

		$storage_root = env('APK_ROOT');
		$md5 = md5_file($inputFile->getPath());
		$target_path = date('Y/m/d', time()).'/'.$md5;
		$target_dir = $storage_root.'/'.$target_path;
		$apkFile = $target_dir.'/'.$inputFile->getClientOriginalName();
		//判断是否重复
		if(!File::exists($target_path)) {
			$inputFile->move($target_dir, $inputFile->getClientOriginalName());
		}
		$apk = new \ApkParser\Parser($apkFile);
		$manifest = $apk->getManifest();
		$iconResourceId = $apk->getManifest()->getApplication()->getIcon();
		$resources = $apk->getResources($iconResourceId);
		//TODO 判断图标大小
		$iconResource = $resources[count($resources)-1];
		File::put($target_dir.'/'.'icon.png', stream_get_contents($apk->getStream($iconResource)));
		$package = new Package();
		//TODO 判断应用名语言
		$package->app_name = $apk->getResources($manifest->getApplication()->getLabel())[0];
		$package->version_name = $manifest->getVersionName();
		$package->version_code = $manifest->getVersionCode();
		$package->package_name = $manifest->getPackageName();
		$package->sdk_level = $manifest->getMinSdkLevel();
		$package->path = $target_path.'/'.$inputFile->getClientOriginalName();
		$package->icon = $target_path.'/icon.png';
		$package->user_id = \Auth::id();
		$package->save();
		return $package;
	}

}