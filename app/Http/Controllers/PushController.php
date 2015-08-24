<?php

namespace App\Http\Controllers;

use App\Push;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Response;
use View;

class PushController extends Controller {
	/**
	 * PushController constructor.
	 */
	public function __construct() {
		View::share('active', 'push');
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex() {
//		Package::join('pushes', 'packages.id', '=', 'pushes.package_id')
//			->join('push_devices', 'pushes.id', '=', 'push_devices.push_id')
//			->where('push_devices.device_id', '=', $device->id)
//			->orderBy('pushes.created_at', 'desc')
//			->groupBy('packages.id')
//			->select('packages.*', 'pushes.id as push_id')
		$pushes = Push::join('push_devices', 'pushes.id', '=', 'push_devices.push_id')
			->join('devices', 'devices.id', '=', 'push_devices.device_id')
			->where('devices.user_id', '=', Auth::id())
			->with('package')
			->orderBy('created_at', 'desc')
			->select('pushes.*')
			->paginate(15);
		return view('push.index')
			->with('pushes', $pushes);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request $request
	 * @return Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request $request
	 * @param  int $id
	 * @return Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id) {
		//
	}
}
