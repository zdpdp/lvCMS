<?php

use Illuminate\Database\Seeder;

class CmsUserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_user')->delete();
        
        \DB::table('cms_user')->insert(array (
            0 => 
            array (
                'id' => 21,
                'account' => 'admin@qq.com',
                'password' => '123456',
                'name' => 'admin',
                'role_id' => 1,
                'head' => '/images/userHead/211501382108.jpg',
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => '2017-08-08 09:20:40',
                'register_ip' => NULL,
                'register_address' => '',
                'state' => 0,
                'sex' => 1,
                'birth' => '2017-07-10',
                'phone' => NULL,
                'email' => '465201770@qq.com',
            ),
            1 => 
            array (
                'id' => 23,
                'account' => 'test@qq.com',
                'password' => '123456',
                'name' => 'test',
                'role_id' => 7,
                'head' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => '2017-08-08 09:26:05',
                'register_ip' => NULL,
                'register_address' => '',
                'state' => 0,
                'sex' => 3,
                'birth' => NULL,
                'phone' => NULL,
                'email' => NULL,
            ),
            2 => 
            array (
                'id' => 24,
                'account' => '1406100112',
                'password' => '123456',
                'name' => '156156',
                'role_id' => 2,
                'head' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => '2017-08-08 09:26:17',
                'register_ip' => NULL,
                'register_address' => '',
                'state' => 0,
                'sex' => 3,
                'birth' => NULL,
                'phone' => NULL,
                'email' => NULL,
            ),
            3 => 
            array (
                'id' => 25,
                'account' => '1406100113',
                'password' => '123456',
                'name' => '156156',
                'role_id' => 3,
                'head' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => '2017-08-08 09:17:11',
                'register_ip' => NULL,
                'register_address' => '',
                'state' => 3,
                'sex' => 3,
                'birth' => NULL,
                'phone' => NULL,
                'email' => NULL,
            ),
        ));
        
        
    }
}