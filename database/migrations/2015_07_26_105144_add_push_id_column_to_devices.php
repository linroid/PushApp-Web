<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPushIdColumnToDevices extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('devices', function (Blueprint $table) {
			$table->string('push_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('devices', function (Blueprint $table) {
			$table->dropColumn('push_id');
		});
	}
}
