<?php

use Illuminate\Database\Seeder;

class CmsFriendsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_friends')->delete();
        
        \DB::table('cms_friends')->insert(array (
            0 => 
            array (
                'id' => 5,
                'name' => '百度',
                'url' => 'http://www.baidu.com',
                'top' => 0,
            ),
            1 => 
            array (
                'id' => 6,
                'name' => '新浪',
                'url' => 'http://www.163.com',
                'top' => 1,
            ),
        ));
        
        
    }
}