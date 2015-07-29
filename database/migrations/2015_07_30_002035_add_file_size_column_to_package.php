<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileSizeColumnToPackage extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('packages', function (Blueprint $table) {
			$table->unsignedInteger('file_size');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('packages', function (Blueprint $table) {
			$table->dropColumn('file_size');
		});
	}
}
