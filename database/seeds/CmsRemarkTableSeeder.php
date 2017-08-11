<?php

use Illuminate\Database\Seeder;

class CmsRemarkTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_remark')->delete();
        
        \DB::table('cms_remark')->insert(array (
            0 => 
            array (
                'id' => 2,
                'articleId' => 22,
                'content' => '1231',
                'userId' => NULL,
                'tempName' => '',
                'ancestor_id' => NULL,
                'father_id' => NULL,
                'created_at' => '2017-08-03 09:56:05',
                'updated_at' => NULL,
                'state' => 1,
            ),
            1 => 
            array (
                'id' => 3,
                'articleId' => 22,
                'content' => '测试测试',
                'userId' => 21,
                'tempName' => '',
                'ancestor_id' => NULL,
                'father_id' => NULL,
                'created_at' => '2017-08-03 09:56:30',
                'updated_at' => NULL,
                'state' => 1,
            ),
            2 => 
            array (
                'id' => 4,
                'articleId' => 22,
                'content' => '再测试下',
                'userId' => NULL,
                'tempName' => '',
                'ancestor_id' => 3,
                'father_id' => NULL,
                'created_at' => '2017-08-03 09:57:20',
                'updated_at' => NULL,
                'state' => 1,
            ),
            3 => 
            array (
                'id' => 5,
                'articleId' => 22,
                'content' => '哈哈',
                'userId' => 21,
                'tempName' => '',
                'ancestor_id' => 2,
                'father_id' => NULL,
                'created_at' => '2017-08-03 09:57:37',
                'updated_at' => NULL,
                'state' => 1,
            ),
            4 => 
            array (
                'id' => 8,
                'articleId' => 22,
                'content' => '12332',
                'userId' => NULL,
                'tempName' => '',
                'ancestor_id' => NULL,
                'father_id' => NULL,
                'created_at' => '2017-08-03 05:47:31',
                'updated_at' => '2017-08-03 05:47:31',
                'state' => 1,
            ),
            5 => 
            array (
                'id' => 9,
                'articleId' => 22,
                'content' => '222',
                'userId' => NULL,
                'tempName' => '',
                'ancestor_id' => NULL,
                'father_id' => NULL,
                'created_at' => '2017-08-03 05:47:42',
                'updated_at' => '2017-08-03 05:47:42',
                'state' => 1,
            ),
            6 => 
            array (
                'id' => 10,
                'articleId' => 22,
                'content' => '2289113',
                'userId' => NULL,
                'tempName' => '',
                'ancestor_id' => 9,
                'father_id' => NULL,
                'created_at' => '2017-08-03 05:48:51',
                'updated_at' => '2017-08-03 05:48:51',
                'state' => 1,
            ),
            7 => 
            array (
                'id' => 12,
                'articleId' => 22,
                'content' => '123123213',
                'userId' => NULL,
                'tempName' => '',
                'ancestor_id' => NULL,
                'father_id' => NULL,
                'created_at' => '2017-08-03 05:50:25',
                'updated_at' => '2017-08-03 05:50:25',
                'state' => 1,
            ),
            8 => 
            array (
                'id' => 13,
                'articleId' => 22,
                'content' => '123',
                'userId' => NULL,
                'tempName' => '大哥',
                'ancestor_id' => 12,
                'father_id' => NULL,
                'created_at' => '2017-08-03 05:51:37',
                'updated_at' => '2017-08-03 05:51:37',
                'state' => 1,
            ),
            9 => 
            array (
                'id' => 16,
                'articleId' => 22,
                'content' => '1999',
                'userId' => NULL,
                'tempName' => NULL,
                'ancestor_id' => NULL,
                'father_id' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'state' => 1,
            ),
        ));
        
        
    }
}