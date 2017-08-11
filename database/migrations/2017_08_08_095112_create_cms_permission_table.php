<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsPermissionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_permission', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('role_id')->nullable()->index('cms_permission_ibfk_1');
			$table->integer('function_id')->nullable()->index('cms_allownav_ibfk_2');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cms_permission');
	}

}
