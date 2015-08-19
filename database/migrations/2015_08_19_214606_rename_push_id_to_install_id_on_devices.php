<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenamePushIdToInstallIdOnDevices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    $platform = DB::getDoctrineSchemaManager()->getDatabasePlatform();
	    $platform->registerDoctrineTypeMapping('enum', 'string');

	    $platform = DB::getDoctrineConnection()->getDatabasePlatform();
	    $platform->registerDoctrineTypeMapping('enum', 'string');

	    Schema::table('devices', function (Blueprint $table) {
		    $table->renameColumn('push_id', 'install_id');
	    });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('devices', function (Blueprint $table) {
		    $table->renameColumn('install_id', 'push_id');
	    });
    }
}
