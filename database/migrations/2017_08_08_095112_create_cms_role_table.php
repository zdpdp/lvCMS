<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_role', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 100)->comment('角色名');
			$table->integer('grade')->comment('角色级别');
			$table->boolean('ifDefault')->nullable()->default(0)->comment('是否是默认角色 1是 0不是');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cms_role');
	}

}
