<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function(Blueprint $table) {
            $table->increments('id');
            $table->string('package_name');
            $table->string('app_name');
            $table->string('version_name');
            $table->unsignedInteger('version_code');
            $table->unsignedTinyInteger('sdk_level');
            $table->unsignedInteger('user_id');
            $table->string('icon');
            $table->string('apk');
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
    public function down()
    {
        Schema::drop('packages');
    }
}
