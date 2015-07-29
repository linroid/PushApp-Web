<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushDevicesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('push_devices', function (Blueprint $table) {
			$table->increments('id');
			$table->enum('status', [0, 1, 2, 3])->default(0);//0:未收到推送/推送失败、1:收到推送、2:下载完成、3:安装完成
			$table->unsignedInteger('device_id');
			$table->foreign('device_id')
				->references('id')
				->on('devices')
				->onUpdate('cascade')
				->onDelete('cascade');
			$table->unsignedInteger('push_id');
			$table->foreign('push_id')
				->references('id')
				->on('pushes')
				->onUpdate('cascade')
				->onDelete('cascade');
			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('push_devices');
	}
}
