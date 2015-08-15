<?php
/**
 * Created by PhpStorm.
 * User: linroid
 * Date: 7/22/15
 * Time: 19:13
 */

namespace app\Http\Controllers;

use App;
use App\Device;
use App\Package;
use App\Push;
use App\PushDevice;
use Auth;
use File;
use Input;
use Lang;
use Redirect;
use Response;
use Session;
use View;

class InstallController extends Controller {

	/**
	 * InstallController constructor.
	 */
	public function __construct() {
		$this->middleware('device_count');
		$this->middleware('auth');
		View::share('active', 'install');
		if (Session::has('package')) {
			return Redirect::to('install/target', ['package', Session::pull('package')]);
		}
	}

	public function getIndex() {
		return View::make('install.index');
	}

	/**
	 * 上传
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function postUpload() {
		$inputFile = Input::file('file');
		$storage_root = env('PACKAGE_ROOT');
		$md5 = md5_file($inputFile->getPathname());
		$size = $inputFile->getSize();;
		$target_path = date('Y/m/d', time()) . '/' . $md5;
		$target_dir = $storage_root . '/' . $target_path;
		//判断是否重复
		if (!File::exists($target_path)) {
			$inputFile->move($target_dir, $inputFile->getClientOriginalName());
		}
		$apkFile = $target_dir . '/' . $inputFile->getClientOriginalName();
		$iconFile = $target_dir . '/icon.png';
		$result = exec(sprintf('java -jar %s %s %s', app_path('Support/apk.jar'), $apkFile, $iconFile));
		if ($result == 'error') {
			return Response::error('解析出错，请检查安装包是否正确', 400);
		}
		$package = new Package(json_decode($result, true));
		$package->path = $target_path . '/' . $inputFile->getClientOriginalName();
		$package->icon = $target_path . '/icon.png';
		$package->user_id = \Auth::id();
		$package->md5 = $md5;
		$package->file_size = $size;
		$package->save();
		return Response::json($package);

//		//判断是否重复
//		if (!File::exists($target_path)) {
//			$inputFile->move($target_dir, $inputFile->getClientOriginalName());
//		}
//
//		$apk = new \ApkParser\Parser($apkFile);
//		$manifest = $apk->getManifest();
//		$iconResourceId = $apk->getManifest()->getApplication()->getIcon();
//		$resources = $apk->getResources($iconResourceId);
//		//TODO 判断图标大小
//		$iconResource = $resources[count($resources) - 1];
//		File::put($target_dir . '/' . 'icon.png', stream_get_contents($apk->getStream($iconResource)));
//		$package = new Package();
//		//TODO 判断应用名语言
//		$package->app_name = $apk->getResources($manifest->getApplication()->getLabel())[0];
//		$package->version_name = $manifest->getVersionName();
//		$package->version_code = $manifest->getVersionCode();
//		$package->package_name = $manifest->getPackageName();
//		$package->sdk_level = $manifest->getMinSdkLevel();
//		$package->path = $target_path . '/' . $inputFile->getClientOriginalName();
//		$package->icon = $target_path . '/icon.png';
//		$package->user_id = \Auth::id();
//		$package->save();
//
//		return Response::json($package);
	}

	/**
	 * 提交Push
	 */
	public function postPush() {
		$data = Input::all();
		$package = Package::findOrFailFromArg($data['package'], Auth::id());

		$devices_ids = Input::get('devices');
		$devices = Device::whereUserId(Auth::id())->whereIn('id', $devices_ids)->get();

		$result = Push::send($devices, $package, Auth::id());
		try{
			if($devices->count()>1) {
				$msg = "已在向{$devices->count()}台设备发出推送...";
			} else {
				$msg = "已向{$devices->first()->alias}发出推送...";
			}
			return redirect('/install')->withToast($msg);
		} catch(\Exception $e) {
			return Redirect::back()->withToast($result);
		}
	}

	/**
	 * 选择设备
	 */
	public function getTarget() {
		$package = Package::findOrFailFromArg(Input::get('package'), Auth::id());

		$devices = Device::whereUserId(Auth::id())->get();
		return View::make('install.target')
			->with('package', $package)
			->with('devices', $devices);
	}
}