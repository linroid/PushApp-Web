<?php

namespace App\Http\Controllers\Api;

use App\Device;
use App\Package;
use App\Push;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Lang;
use Response;

class PushController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
	    $device = Device::current();

	    $package = Package::findOrFailFromArg(Input::get('package'), $device->user_id);

	    $ids = explode(',', Input::get('devices'));
	    $devices = Device::whereUserId($device->user_id)->whereIn('id', $ids)->get();
	    try{
		    $push = Push::send($devices, $package, $device->user_id);
		    return Response::json($push);
	    } catch(\Exception $e) {
		    return Response::exception($e);
	    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
