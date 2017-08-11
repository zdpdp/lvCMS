<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsArticleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_article', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title')->nullable()->comment('文章标题');
			$table->integer('classId')->nullable()->index('文章属于哪个类别')->comment('类别');
			$table->integer('userId')->nullable()->comment('作者');
			$table->timestamps();
			$table->text('content', 65535)->nullable()->comment('内容');
			$table->boolean('original')->nullable()->comment('是否原创 1是 0否');
			$table->string('source')->nullable()->comment('文章来源 （非原创基础上）');
			$table->string('thumbnail')->nullable()->comment('缩略图');
			$table->integer('clickNum')->nullable()->default(0)->comment('点击数量');
			$table->integer('state')->nullable()->comment('状态 0置顶 1正常 2草稿 3回收站');
			$table->boolean('top')->nullable()->default(0)->comment('1置顶 0不置顶');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cms_article');
	}

}
