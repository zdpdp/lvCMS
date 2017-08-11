<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Visit extends Model
{
    //
    //指定表名
    protected $table = 'cms_visit_log';

    //指定主键
    protected $primaryKey ="id";

    //是否自动维护 create_at 和 updated_dt
    public  $timestamps = false;

    //protected $hidden = ['id'];

    protected $guarded = [];

    static public function staticCount($type,$toDate,$number)
    {
        if($type==0){
            //日
            $temp = "unix_timestamp(DATE_SUB(FROM_UNIXTIME($toDate),INTERVAL $number DAY))";
            $sql ="select DATE_FORMAT(time,'%Y/%m/%d') name,type,count(id) count from cms_visit_log group by type,name having unix_timestamp(name) between $temp and $toDate ";
        }else if($type==1){
            //月
            $temp = "unix_timestamp(DATE_SUB(FROM_UNIXTIME($toDate),INTERVAL $number MONTH))";
            $sql ="select DATE_FORMAT(time,'%Y/%m/01') name,type,count(id) count from cms_visit_log group by type,name having unix_timestamp(name) between $temp and $toDate ";
        }else if($type==2){
            //年
            $temp = "unix_timestamp(DATE_SUB(FROM_UNIXTIME($toDate),INTERVAL $number YEAR))";
            $sql ="select DATE_FORMAT(time,'%Y/01/01') name,type,count(id) count from cms_visit_log group by type,name having unix_timestamp(name) between $temp and $toDate ";
        }


        $ret = DB::select($sql);
        return $ret;
    }


}
