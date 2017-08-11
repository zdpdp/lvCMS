<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsFriendsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_friends', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name');
			$table->string('url');
			$table->boolean('top')->default(0)->comment('是否置顶（显示首页） 1是 0否');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cms_friends');
	}

}
