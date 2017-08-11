<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCmsSiteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cms_site', function(Blueprint $table)
		{
			$table->foreign('defaultRole', 'cms_site_ibfk_1')->references('id')->on('cms_role')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cms_site', function(Blueprint $table)
		{
			$table->dropForeign('cms_site_ibfk_1');
		});
	}

}
