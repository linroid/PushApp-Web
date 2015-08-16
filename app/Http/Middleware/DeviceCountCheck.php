<?php

namespace App\Http\Middleware;

use App\Device;
use Auth;
use Closure;
use Redirect;

class DeviceCountCheck {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		//如果还没有绑定任何设备，跳转到绑定设备页面
		if (Device::whereUserId(Auth::id())->count() == 0) {
			return Redirect::to('/device/bind')->withToast('请先绑定至少一台设备');
		}
		return $next($request);
	}
}
