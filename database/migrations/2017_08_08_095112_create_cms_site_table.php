<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsSiteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_site', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name')->comment('站点名称');
			$table->string('logo')->nullable();
			$table->string('icon')->nullable();
			$table->integer('defaultRole')->index('cms_site_ibfk_1')->comment('用户注册时默认角色');
			$table->boolean('openRegister')->comment('是否开放注册 1开放 0不开放');
			$table->string('ICB')->nullable()->comment('备案号');
			$table->string('email')->nullable();
			$table->string('contacts')->nullable();
			$table->string('phone')->nullable();
			$table->string('discription')->nullable();
			$table->string('qq')->nullable();
			$table->string('keyWord')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cms_site');
	}

}
