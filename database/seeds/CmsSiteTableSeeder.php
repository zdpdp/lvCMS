<?php

use Illuminate\Database\Seeder;

class CmsSiteTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_site')->delete();
        
        \DB::table('cms_site')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'CMS',
                'logo' => '/images/siteImg/logo1501754713.jpg',
                'icon' => '/images/siteImg/icon1501754713.jpg',
                'defaultRole' => 3,
                'openRegister' => 1,
                'ICB' => '未备案',
                'email' => '465201770@qq.com',
                'contacts' => NULL,
                'phone' => NULL,
                'discription' => 'CMS',
                'qq' => '465201770',
                'keyWord' => 'CMS',
            ),
        ));
        
        
    }
}