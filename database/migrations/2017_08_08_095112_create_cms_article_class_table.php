<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsArticleClassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_article_class', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('fatherId')->nullable()->index('父类别');
			$table->string('className')->comment('类别名');
			$table->boolean('remarkable')->default(1)->comment('是否允许评论 1完全开放 2完全禁止 3登录后允许');
			$table->boolean('visitable')->default(1)->comment('游客允许浏览 1完全开放 2完全禁止 3登录后允许');
			$table->boolean('downloadable')->default(1)->comment('游客是否允许下载附件 1完全开放 2完全禁止 3登录后允许');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cms_article_class');
	}

}
