<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsVisitLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_visit_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->dateTime('time')->nullable();
			$table->string('ip')->nullable();
			$table->boolean('type')->nullable()->default(0)->comment('0访问前台 1登录');
			$table->integer('userId')->nullable()->comment('记录登录的用户ID');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cms_visit_log');
	}

}
