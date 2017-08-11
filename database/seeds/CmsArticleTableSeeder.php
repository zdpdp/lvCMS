<?php

use Illuminate\Database\Seeder;

class CmsArticleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_article')->delete();
        
        \DB::table('cms_article')->insert(array (
            0 => 
            array (
                'id' => 22,
                'title' => '测试3',
                'classId' => 9,
                'userId' => 21,
                'created_at' => '2017-07-30 03:38:23',
                'updated_at' => '2017-08-08 09:26:32',
                'content' => '<p>你好啊哈哈你好啊哈哈你好啊哈哈你好啊哈哈你好啊哈哈</p><p>你好啊哈哈你好啊哈哈</p><p><br/></p><p>你好啊哈哈</p><p>你好啊哈哈</p>',
                'original' => 1,
                'source' => '',
                'thumbnail' => '/images/userHead/211501385903.jpg',
                'clickNum' => 4,
                'state' => 0,
                'top' => 1,
            ),
            1 => 
            array (
                'id' => 23,
                'title' => '测试2',
                'classId' => 9,
                'userId' => 21,
                'created_at' => '2017-07-30 11:39:01',
                'updated_at' => '2017-08-07 15:14:24',
            'content' => '<p style="white-space: normal;"><br/></p><p style="white-space: normal;"><img src="/ueditor/php/upload/image/20170802/1501658589613677.png" title="1501658589613677.png" alt="image.png"/></p><p style="white-space: normal;"><span style="color: rgb(255, 0, 0);">大家好大家好大家好大家好大家好大家好</span></p><p style="white-space: normal;"><span style="color: rgb(255, 0, 0);">大家好</span></p><h1 style="white-space: normal;"><span style="color: rgb(255, 0, 0);">大家好</span></h1><h1 style="white-space: normal;"><span style="color: rgb(255, 0, 0);">大家好</span></h1><h1 style="white-space: normal;"><span style="color: rgb(255, 0, 0);">大家好大家好</span></h1><p style="white-space: normal;"><span style="color: rgb(255, 0, 0);">大家好大家好大家好大家好大家好大家好</span></p><p style="white-space: normal;">大家好</p><h1 style="white-space: normal;">大家好</h1><h1 style="white-space: normal;">大家好</h1><h1 style="white-space: normal;">大家好大家好</h1><p style="white-space: normal;">大家好大家好大家好大家好大家好大家好</p><p style="white-space: normal;">大家好</p><h1 style="white-space: normal;">大家好</h1><h1 style="white-space: normal;">大家好</h1><p style="white-space: normal;">大家好大家好大家好大家好大家好大家好</p><p style="white-space: normal;">大家好</p><h1 style="white-space: normal;">大家好</h1><h1 style="white-space: normal;">大家好</h1><h1 style="white-space: normal;">大家好大家好</h1><p style="white-space: normal;">大家好大家好大家好大家好大家好大家好</p><p style="white-space: normal;">大家好</p><h1 style="white-space: normal;">大家好</h1><h1 style="white-space: normal;">大家好</h1><h1 style="white-space: normal;">大家好大家好</h1><p style="white-space: normal;">大家好大家好大家好大家好大家好大家好</p><p style="white-space: normal;">大家好</p><h1 style="white-space: normal;">大家好</h1><h1 style="white-space: normal;">大家好</h1><h1 style="white-space: normal;">大</h1><h1 style="white-space: normal;">大</h1>',
                'original' => 1,
                'source' => '',
                'thumbnail' => '/images/userHead/211501385909.jpg',
                'clickNum' => 12,
                'state' => 0,
                'top' => 1,
            ),
            2 => 
            array (
                'id' => 24,
                'title' => '测试1',
                'classId' => 7,
                'userId' => 21,
                'created_at' => '2017-08-02 15:51:47',
                'updated_at' => '2017-08-08 09:21:57',
                'content' => '<p>这是一篇测试文章<img src="/ueditor/php/upload/image/20170802/1501689078813140.png" title="1501689078813140.png" alt="image.png"/></p>',
                'original' => 1,
                'source' => NULL,
                'thumbnail' => '/images/articleImg/211501689107.jpg',
                'clickNum' => 17,
                'state' => 1,
                'top' => 0,
            ),
        ));
        
        
    }
}