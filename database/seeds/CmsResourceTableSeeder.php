<?php

use Illuminate\Database\Seeder;

class CmsResourceTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_resource')->delete();
        
        \DB::table('cms_resource')->insert(array (
            0 => 
            array (
                'id' => 1,
                'type' => 1,
                'link_id' => 11,
                'name' => '2.jpg',
                'position' => './../resources/attachment/20170728/11501219774.jpg',
                'downloadNum' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'type' => 1,
                'link_id' => 11,
                'name' => '2.jpg',
                'position' => './../resources/attachment/20170728/11501220015.jpg',
                'downloadNum' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'type' => 1,
                'link_id' => 12,
                'name' => '2.jpg',
                'position' => './../resources/attachment/20170728/11501219774.jpg',
                'downloadNum' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'type' => 1,
                'link_id' => 12,
                'name' => '2.jpg',
                'position' => './../resources/attachment/20170728/11501220015.jpg',
                'downloadNum' => 0,
            ),
            4 => 
            array (
                'id' => 11,
                'type' => 1,
                'link_id' => 22,
                'name' => '1.jpg',
                'position' => './../resources/attachment/20170729/11501306890.jpg',
                'downloadNum' => 0,
            ),
            5 => 
            array (
                'id' => 12,
                'type' => 1,
                'link_id' => 22,
                'name' => '2.jpg',
                'position' => './../resources/attachment/20170730/211501385893.jpg',
                'downloadNum' => 0,
            ),
            6 => 
            array (
                'id' => 13,
                'type' => 1,
                'link_id' => 22,
                'name' => '360Safe.exe',
                'position' => './../resources/attachment/20170730/211501385896.exe',
                'downloadNum' => 0,
            ),
            7 => 
            array (
                'id' => 14,
                'type' => 1,
                'link_id' => 23,
                'name' => '2.jpg',
                'position' => './../resources/attachment/20170730/211501385893.jpg',
                'downloadNum' => 0,
            ),
            8 => 
            array (
                'id' => 15,
                'type' => 1,
                'link_id' => 23,
                'name' => '360Safe.exe',
                'position' => './../resources/attachment/20170730/211501385896.exe',
                'downloadNum' => 0,
            ),
            9 => 
            array (
                'id' => 16,
                'type' => 1,
                'link_id' => 24,
                'name' => 'tm-about-img.jpg',
                'position' => './../resources/attachment/20170802/211501689068.jpg',
                'downloadNum' => 0,
            ),
            10 => 
            array (
                'id' => 17,
                'type' => 1,
                'link_id' => 24,
                'name' => 'tm-img-100x100-5.jpg',
                'position' => './../resources/attachment/20170802/211501689071.jpg',
                'downloadNum' => 0,
            ),
        ));
        
        
    }
}