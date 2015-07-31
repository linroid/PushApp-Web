<?php
/**
 * Created by PhpStorm.
 * User: linroid
 * Date: 7/24/15
 * Time: 16:05
 */

namespace app\Http\Controllers\Api;


use App\Device;
use App\Package;
use App\PushDevice;
use DB;
use Response;

class PackageController extends ApiController {
	public function getIndex() {
		$device = Device::current();
//		DB::table('packages')->join()->
		$packages = Package::join('pushes', 'packages.id', '=', 'pushes.package_id')
			->join('push_devices', 'pushes.id', '=', 'push_devices.push_id')
			->where('push_devices.device_id', '=', $device->id)
			->orderBy('pushes.created_at', 'desc')
			->paginate(30);
		return Response::json($packages);
//		var_dump($packages);
	}
}