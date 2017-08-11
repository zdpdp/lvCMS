<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_user', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('account')->unique('userAccount')->comment('用户登录账号');
			$table->string('password')->comment('用户密码');
			$table->string('name');
			$table->integer('role_id')->index('userRole')->comment('用户身份');
			$table->string('head')->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->string('register_ip')->nullable()->comment('注册IP地址');
			$table->string('register_address')->nullable()->default('')->comment('注册地址');
			$table->integer('state')->default(0)->comment('0正常 1禁止登录 2禁止发言 3等待验证 ');
			$table->boolean('sex')->nullable()->default(3)->comment('1男 2女 3未知');
			$table->date('birth')->nullable()->comment('生日');
			$table->string('phone', 30)->nullable()->comment('手机号码');
			$table->string('email')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cms_user');
	}

}
