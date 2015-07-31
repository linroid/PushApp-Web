<?php

namespace App\Providers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\ServiceProvider;
use Response;

class ResponseMacroServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		Response::macro('error', function($message, $status_code = 400)
		{
			return Response::json(array(
				'message' => $message,
				'status_code' => $status_code
			), $status_code);
		});
		Response::macro('errors', function(MessageBag $errors){
			return Response::error($errors->first(), 400);
		});
		Response::macro('noContent', function() {
			return Response::make();
		});
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
