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
		Schema::create('bind_tokens', function (Blueprint $table) {
			$table->increments('id');
			$table->string('value')->unique();
			$table->timestamp('expire_in');
			$table->unsignedInteger('user_id');
			$table->timestamps();
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
	public function down() {
		Schema::drop('bind_tokens');
	}
}
