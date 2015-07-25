<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_accounts', function(Blueprint $table) {
            $table->string('token');
            $table->string('id');
            $table->string('platform');
            $table->string('avatar');
            $table->string('nickname');
            $table->string('homepage');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->unique(['id', 'platform']);
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
        Schema::drop('social_accounts');
    }
}
