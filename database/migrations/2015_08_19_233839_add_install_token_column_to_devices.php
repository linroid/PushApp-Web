<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInstallTokenColumnToDevices extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('devices', function (Blueprint $table) {
			$table->string('install_token')->unique();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('devices', function (Blueprint $table) {
			$table->dropColumn('install_token');
		});
	}
}
