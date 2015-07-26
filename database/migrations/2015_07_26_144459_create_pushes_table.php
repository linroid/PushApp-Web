<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pushes', function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('sendno');
            $table->unsignedInteger('msg_id');
            $table->boolean('is_ok');
            $table->unsignedInteger('package_id');
            $table->foreign('package_id')
                ->references('id')
                ->on('packages')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
    public function down()
    {
        Schema::drop('pushes');
    }
}
