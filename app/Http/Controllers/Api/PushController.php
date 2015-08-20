<?php

namespace App\Http\Controllers\Api;

use App\Device;
use App\DUAuth;
use App\Package;
use App\Push;
use App\Token;
use Auth;
use Exception;
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

	    if(Input::hasFile('file')) {
		    $inputFile = Input::file('file');
		    $package = Package::createFromInputFile($inputFile, $device->user_id);
	    } else {
		    $package = Package::findOrFailFromArg(Input::get('package'), $device->user_id);
	    }

	    $ids = explode(',', Input::get('devices'));
	    if (count($ids) == 1 && !is_numeric($ids[0])) {
			$token = Token::whereValue($ids[0])->valid()->first();
		    if ($token) {
			    $devices = Device::whereId($token->owner)->get();
		    } else {
			    return Response::error(trans('errors.expired_device_qrcode').$ids[0], 400);
		    }
	    }
	    if (empty($devices)) {

		    $devices = Device::whereIn('id', $ids)
			    ->where(function ($query) use ($device) {
				    $query->whereUserId($device->user_id)
					    ->orWhere(function ($query) use ($device) {
						    $authed_device_ids = DUAuth::whereUserId($device->user_id)->lists('device_id');
						    $query->whereIn('id', $authed_device_ids);
					    });
			    })
			    ->get();
	    }
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
