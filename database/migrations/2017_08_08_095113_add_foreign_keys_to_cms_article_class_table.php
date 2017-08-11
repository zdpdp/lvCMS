<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCmsArticleClassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cms_article_class', function(Blueprint $table)
		{
			$table->foreign('fatherId', '父类别')->references('id')->on('cms_article_class')->onUpdate('RESTRICT')->onDelete('SET NULL');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cms_article_class', function(Blueprint $table)
		{
			$table->dropForeign('父类别');
		});
	}

}
