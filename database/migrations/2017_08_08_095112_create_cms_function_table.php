<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsFunctionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_function', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('grade')->comment('权限级别 1导航栏一级菜单  2导航栏二级菜单 3页面功能');
			$table->string('EnglishName')->nullable();
			$table->string('name')->comment('权限名');
			$table->string('url')->nullable();
			$table->string('icon')->nullable();
			$table->integer('father_id')->nullable()->comment('父级权限');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cms_function');
	}

}
