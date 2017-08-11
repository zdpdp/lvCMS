<?php

use Illuminate\Database\Seeder;

class CmsArticleClassTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_article_class')->delete();
        
        \DB::table('cms_article_class')->insert(array (
            0 => 
            array (
                'id' => 1,
                'fatherId' => NULL,
                'className' => '专题1',
                'remarkable' => 1,
                'visitable' => 1,
                'downloadable' => 1,
            ),
            1 => 
            array (
                'id' => 3,
                'fatherId' => NULL,
                'className' => '专题2',
                'remarkable' => 1,
                'visitable' => 1,
                'downloadable' => 3,
            ),
            2 => 
            array (
                'id' => 5,
                'fatherId' => 1,
                'className' => '专题1-1',
                'remarkable' => 1,
                'visitable' => 1,
                'downloadable' => 1,
            ),
            3 => 
            array (
                'id' => 6,
                'fatherId' => NULL,
                'className' => '专题3',
                'remarkable' => 1,
                'visitable' => 1,
                'downloadable' => 3,
            ),
            4 => 
            array (
                'id' => 7,
                'fatherId' => 3,
                'className' => '专题2-1',
                'remarkable' => 1,
                'visitable' => 1,
                'downloadable' => 1,
            ),
            5 => 
            array (
                'id' => 9,
                'fatherId' => 1,
                'className' => '专题1-2',
                'remarkable' => 1,
                'visitable' => 1,
                'downloadable' => 1,
            ),
            6 => 
            array (
                'id' => 10,
                'fatherId' => 6,
                'className' => '专题3-1',
                'remarkable' => 2,
                'visitable' => 1,
                'downloadable' => 1,
            ),
        ));
        
        
    }
}