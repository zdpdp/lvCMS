<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCmsRemarkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cms_remark', function(Blueprint $table)
		{
			$table->foreign('ancestor_id', 'cms_remark_ibfk_1')->references('id')->on('cms_remark')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('father_id', 'cms_remark_ibfk_2')->references('id')->on('cms_remark')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cms_remark', function(Blueprint $table)
		{
			$table->dropForeign('cms_remark_ibfk_1');
			$table->dropForeign('cms_remark_ibfk_2');
		});
	}

}
