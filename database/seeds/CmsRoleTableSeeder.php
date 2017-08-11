<?php

use Illuminate\Database\Seeder;

class CmsRoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_role')->delete();
        
        \DB::table('cms_role')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '超级管理员',
                'grade' => 1,
                'ifDefault' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '管理员',
                'grade' => 2,
                'ifDefault' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '普通用户',
                'grade' => 9,
                'ifDefault' => 1,
            ),
            3 => 
            array (
                'id' => 7,
                'name' => '测试',
                'grade' => 3,
                'ifDefault' => 0,
            ),
        ));
        
        
    }
}