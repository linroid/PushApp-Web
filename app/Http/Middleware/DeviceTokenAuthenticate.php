<?php

namespace App\Http\Middleware;

use App\Device;
use Closure;
use Lang;
use Response;

class DeviceTokenAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('X-Token');
        if(!Device::attempt($token)) {
            return Response::error(Lang::get('errors.unauthorized'), 401);
        }
        return $next($request);
    }
}
