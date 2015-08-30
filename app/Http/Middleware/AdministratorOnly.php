<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Response;

class AdministratorOnly
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
	    if (Auth::guest() || Auth::id()!=env('ADMIN_USER_ID', 0)) {
		    return Response::error('You have no permission', 403);
	    }
        return $next($request);
    }
}
