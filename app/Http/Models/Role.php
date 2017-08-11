<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    //
    //指定表名
    protected $table = 'cms_role';

    //指定主键
    protected $primaryKey ="id";

    //是否自动维护 create_at 和 updated_dt
    public  $timestamps = false;

    /*
     * 角色与用户是一对多的关系
     */
    public function User()
    {
        return $this->hasMany('App\Http\Models\User');
    }
    /**
     * @return 获取级别，名称，是否默认角色
     */
    static public function getAllRoleInfo()
    {

        $sql = "select id role_id, name,grade,ifDefault,0 num FROM cms_role";

        return DB::select($sql);
    }

    static public function cratePermitssion($getRole,$id)
    {
        $sql ="select function_id from cms_permission where role_id = (SELECT id from cms_role where grade =? limit 1)";

        $ret = DB::select($sql,[$getRole['grade']]);

        foreach ($ret as $val)
        {
           $ret2 = Permission::create(['role_id'=>$id,'function_id'=>$val->function_id]);
           if(!$ret2){
               return ['result'=>false];
           }

        }
        return ['result'=>true];
    }


}
