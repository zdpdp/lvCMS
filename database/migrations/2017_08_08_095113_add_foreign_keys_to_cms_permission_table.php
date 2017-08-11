<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCmsPermissionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cms_permission', function(Blueprint $table)
		{
			$table->foreign('role_id', 'cms_permission_ibfk_1')->references('id')->on('cms_role')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cms_permission', function(Blueprint $table)
		{
			$table->dropForeign('cms_permission_ibfk_1');
		});
	}

}
