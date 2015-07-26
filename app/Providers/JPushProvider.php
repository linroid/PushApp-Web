<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JPush\JPushClient;

class JPushProvider extends ServiceProvider {
	/**
	 * 指定是否延缓提供者加载。
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->singleton('JPush\JPushClient', function ($app) {
			return new JPushClient(env('JPUSH_APP_KEY'), env('JPUSH_APP_SECRET'));
		});
	}
	/**
	 * 取得提供者所提供的服务。
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['JPush\JPushClient'];
	}

}
