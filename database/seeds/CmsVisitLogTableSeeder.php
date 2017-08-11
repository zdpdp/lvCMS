<?php

use Illuminate\Database\Seeder;

class CmsVisitLogTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_visit_log')->delete();
        
        \DB::table('cms_visit_log')->insert(array (
            0 => 
            array (
                'id' => 2,
                'time' => '2017-08-05 10:49:43',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            1 => 
            array (
                'id' => 3,
                'time' => '2017-08-05 11:01:40',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            2 => 
            array (
                'id' => 4,
                'time' => '2017-08-05 11:20:48',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            3 => 
            array (
                'id' => 5,
                'time' => '2017-08-05 11:32:32',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            4 => 
            array (
                'id' => 6,
                'time' => '2017-08-06 10:10:40',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            5 => 
            array (
                'id' => 7,
                'time' => '2017-08-06 10:21:01',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            6 => 
            array (
                'id' => 8,
                'time' => '2017-08-06 10:33:10',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            7 => 
            array (
                'id' => 9,
                'time' => '2017-08-06 11:24:56',
                'ip' => '127.0.0.1',
                'type' => 1,
                'userId' => 21,
            ),
            8 => 
            array (
                'id' => 10,
                'time' => '2017-07-07 12:26:19',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            9 => 
            array (
                'id' => 11,
                'time' => '2017-05-18 15:15:25',
                'ip' => NULL,
                'type' => 0,
                'userId' => NULL,
            ),
            10 => 
            array (
                'id' => 12,
                'time' => '2017-08-07 09:33:09',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            11 => 
            array (
                'id' => 13,
                'time' => '2017-08-07 09:33:30',
                'ip' => '127.0.0.1',
                'type' => 1,
                'userId' => 21,
            ),
            12 => 
            array (
                'id' => 14,
                'time' => '2017-08-07 13:10:29',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            13 => 
            array (
                'id' => 15,
                'time' => '2017-08-07 14:52:02',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            14 => 
            array (
                'id' => 16,
                'time' => '2017-08-07 15:04:33',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            15 => 
            array (
                'id' => 17,
                'time' => '2017-08-07 15:31:10',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            16 => 
            array (
                'id' => 18,
                'time' => '2017-08-07 15:32:47',
                'ip' => '127.0.0.1',
                'type' => 1,
                'userId' => 21,
            ),
            17 => 
            array (
                'id' => 19,
                'time' => '2017-08-07 16:03:35',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            18 => 
            array (
                'id' => 20,
                'time' => '2017-08-07 16:16:54',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            19 => 
            array (
                'id' => 21,
                'time' => '2017-08-07 16:27:11',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            20 => 
            array (
                'id' => 22,
                'time' => '2017-08-07 23:14:33',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            21 => 
            array (
                'id' => 23,
                'time' => '2017-08-07 23:14:45',
                'ip' => '127.0.0.1',
                'type' => 1,
                'userId' => 21,
            ),
            22 => 
            array (
                'id' => 24,
                'time' => '2017-08-08 09:12:11',
                'ip' => '127.0.0.1',
                'type' => 1,
                'userId' => 21,
            ),
            23 => 
            array (
                'id' => 25,
                'time' => '2017-08-08 09:13:15',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            24 => 
            array (
                'id' => 26,
                'time' => '2017-08-08 09:26:32',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            25 => 
            array (
                'id' => 27,
                'time' => '2017-08-08 09:27:01',
                'ip' => '127.0.0.1',
                'type' => 1,
                'userId' => 23,
            ),
            26 => 
            array (
                'id' => 28,
                'time' => '2017-08-08 09:28:10',
                'ip' => '127.0.0.1',
                'type' => 1,
                'userId' => 21,
            ),
            27 => 
            array (
                'id' => 29,
                'time' => '2017-08-08 10:02:10',
                'ip' => '127.0.0.1',
                'type' => 0,
                'userId' => NULL,
            ),
            28 => 
            array (
                'id' => 30,
                'time' => '2017-08-08 10:02:32',
                'ip' => '127.0.0.1',
                'type' => 1,
                'userId' => 21,
            ),
        ));
        
        
    }
}