<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Resource extends Model
{
    //
    //指定表名
    protected $table = 'cms_resource';

    //指定主键
    protected $primaryKey ="id";

    //是否自动维护 create_at 和 updated_dt
    public  $timestamps = false;

    protected $guarded =[];
    protected $hidden = [];

    static public function getAttachment($articleId)
    {
        $sql = "select name,position url from cms_resource where type =1 and  link_id = ?";

        $ret = DB::select($sql,[$articleId]);

        return $ret ;
    }
}
