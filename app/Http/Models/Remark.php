<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Remark extends Model
{
    //
    //指定表名
    protected $table = 'cms_remark';

    //指定主键
    protected $primaryKey ="id";

    //是否自动维护 create_at 和 updated_dt
    public  $timestamps = true;

    //protected $hidden = ['id'];

    protected $guarded = [];

    static public function getRemarks($page=1,$pageSize=25,$searchInfo='',$type=0)
    {
        $page=$page-1;


        $sql = "select a.*,b.title,c.name from cms_remark a LEFT JOIN cms_user c  on a.userId=c.id LEFT JOIN cms_article b on a.articleId=b.id";

        if($type==1){
            //内容
            $sql.=" where a.content like '%$searchInfo%'";
        }else if($type==2){
            //标题
            $sql.=" where b.title like '%$searchInfo%'";
        }else if($type==3){
            if($searchInfo=='游客'){
                $sql.=" where a.tempName is null ";
            }else{
                $sql.=" where c.name like '%$searchInfo%' or a.tempName like '%$searchInfo%'";
            }
        }else if($type==4){
            if($searchInfo=='1'){
                $sql.=" where a.ancestor_id is null and a.father_id is null";
            }else if ($searchInfo=='2'){
                $sql.=" where a.ancestor_id is not null and a.father_id is null";
            }else if($searchInfo=='3'){
                $sql.=" where a.ancestor_id is not null and a.father_id is not null";

            }

        }

        $sql.= ' order by created_at desc';
        $articles = DB::select($sql);

        $total = count($articles);

        $ret = array_splice($articles,$page*$pageSize,$pageSize);

        foreach ($ret as $val){
            if($val->ancestor_id&&$val->father_id){
                $val->grade = '3';
            }else if ($val->ancestor_id&&!$val->father_id){
                $val->grade = '2';
            }else{
                $val->grade = '1';

            }
        }

        return ['result'=>true,'total'=>$total,'remark'=>$ret];
    }

}
