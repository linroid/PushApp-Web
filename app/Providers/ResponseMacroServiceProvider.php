<?php

namespace App\Providers;

use Exception;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ServiceProvider;
use Lang;
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
		Response::macro('exception', function(Exception $e) {
			if($e instanceof \HttpResponse) {
				return Response::error($e->getMessage(), $e->getCode());
			}
			\Log::error($e->getMessage());
			return Response::error(Lang::get('errors.server_exception'), 500);
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
