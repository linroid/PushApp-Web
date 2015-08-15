<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('devices', function (Blueprint $table) {
			$table->increments('id');
			$table->string('model');
			$table->string('alias');
			$table->string('sdk_level');
			$table->string('os_name');
			$table->string('height');
			$table->string('width');
			$table->string('dpi');
//			$table->string('imei');
//			$table->string('mac');
			$table->string('unique_id');
			$table->string('memory_size');
			$table->string('cpu_type');
			$table->string('token')->unique();
			$table->enum('network_type', ['wifi', 'mobile', 'unknown'])->default('unknown');
			$table->unsignedInteger('user_id');
			$table->timestamps();

			$table->unique(['unique_id', 'user_id']);
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('devices');
	}
}