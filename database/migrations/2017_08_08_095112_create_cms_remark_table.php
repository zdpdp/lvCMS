<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsRemarkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_remark', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('articleId');
			$table->text('content', 65535)->nullable();
			$table->integer('userId')->nullable();
			$table->string('tempName')->nullable();
			$table->integer('ancestor_id')->nullable()->index('ancestor_id')->comment('最高层级 祖宗评论');
			$table->integer('father_id')->nullable()->index('father_id')->comment('回复属于哪个评论');
			$table->timestamps();
			$table->boolean('state')->default(1)->comment('1正常 0回收站');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cms_remark');
	}

}
