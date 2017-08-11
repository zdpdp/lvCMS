<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
		  $this->call(CmsRoleTableSeeder::class);
		  $this->call(CmsArticleClassTableSeeder::class);
        $this->call(CmsArticleTableSeeder::class);
    
        $this->call(CmsFriendsTableSeeder::class);
        $this->call(CmsFunctionTableSeeder::class);
        $this->call(CmsPermissionTableSeeder::class);
        $this->call(CmsRemarkTableSeeder::class);
        $this->call(CmsResourceTableSeeder::class);
      
        $this->call(CmsSiteTableSeeder::class);
        $this->call(CmsUserTableSeeder::class);
        $this->call(CmsVisitLogTableSeeder::class);
        $this->call(MigrationsTableSeeder::class);
    }
}
