<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Site extends Model
{
    //
    //指定表名
    protected $table = 'cms_site';

    //指定主键
    protected $primaryKey ="id";

    //是否自动维护 create_at 和 updated_dt
    public  $timestamps = false;

    protected $hidden = ['id'];

    static public function updateSite($iconSql,$logoSql,$arr)
    {
        $sql = "update cms_site set name =:name ,defaultRole=:defaultRole, openRegister=:openRegister,ICB=:ICB,email=:email,contacts=:contacts,
                phone=:phone,discription=:discription,qq=:qq,keyWord=:keyWord $iconSql $logoSql where id =1 ";

        return DB::update($sql,$arr);


    }

}
