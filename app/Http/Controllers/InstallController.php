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
use App\DUAuth;
use App\Package;
use App\Push;
use App\PushDevice;
use Auth;
use File;
use Input;
use Lang;
use Mockery\CountValidator\Exception;
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

	public function postIndex() {
		if (Input::has('url')) {
			$url = Input::get('url');
			if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
				return Redirect::back()->withToast(trans('errors.invalid_url'));
			}
			return Redirect::to('/install/target')->withInput(Input::all());
		}
	}

	/**
	 * 上传
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function postUpload() {
		$inputFile = Input::file('file');
		try {
			$package = Package::createFromInputFile($inputFile, Auth::id());
			return Response::json($package);
		} catch (Exception $e) {
			return Response::exception($e);
		}

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

		$devices_ids = Input::get('devices');
		$devices = Device::whereUserId(Auth::id())
//							->orWhere(function($query) use($devices_ids) {
//								$ids = DUAuth::whereUserId(Auth::id())->lists('device_id');
//								$query->whereIn('id', $ids)->whereIn('id', $devices_ids);
//							})
							->whereIn('devices.id', $devices_ids)
							->get();
		if(!Input::has('package') && Input::has('url')) {
			$this->dispatch(new App\Jobs\PushApk(Auth::user(), $data['url'], $devices));
			return redirect('/install')->withToast('服务器正在努力处理中，请稍等...');
		}
		$package = Package::findOrFailFromArg($data['package'], Auth::id());

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
		$devices = Device::whereUserId(Auth::id())
					->orWhere(function($query) {
						$authed_device_ids = DUAuth::whereUserId(Auth::id())->lists('device_id');
						$query->whereIn('id', $authed_device_ids);
					})->get();
		$response = View::make('install.target')
					->with('devices', $devices);
		if(Input::has('package')) {
			$package = Package::findOrFailFromArg(Input::get('package'), Auth::id());
			return $response->with('package', $package);
		} else {
			$url = Input::old('url');
			if (empty($url)) {
				return redirect('install')->withToast('发生异常');
			}

			return  $response->with('url', $url);
		}
	}
}