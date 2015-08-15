<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('auth', function (Blueprint $table) {
		    $table->increments('id');
		    $table->unsignedInteger('device_id');
		    $table->unsignedInteger('user_id');
		    $table->timestamps();
		    $table->foreign('device_id')
			    ->references('id')
			    ->on('devices')
			    ->onUpdate('cascade')
			    ->onDelete('cascade');
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
	    Schema::drop('auth');
    }
}
