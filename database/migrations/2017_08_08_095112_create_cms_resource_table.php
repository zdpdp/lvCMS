<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsResourceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_resource', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('type')->comment('1文章缩略图  2文章附件');
			$table->integer('link_id')->comment('关联Id');
			$table->string('name')->nullable()->comment('资源名  ');
			$table->string('position')->comment('存储位置');
			$table->integer('downloadNum')->nullable()->default(0)->comment('下载次数');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cms_resource');
	}

}
