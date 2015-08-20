<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBindTokensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tokens', function (Blueprint $table) {
			$table->increments('id');
			$table->string('type');
			$table->string('value')->unique();
			$table->unsignedInteger('owner');
			$table->timestamp('expire_in');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('tokens');
	}
}
