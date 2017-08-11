<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCmsArticleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cms_article', function(Blueprint $table)
		{
			$table->foreign('classId', '文章属于哪个类别')->references('id')->on('cms_article_class')->onUpdate('RESTRICT')->onDelete('SET NULL');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cms_article', function(Blueprint $table)
		{
			$table->dropForeign('文章属于哪个类别');
		});
	}

}
