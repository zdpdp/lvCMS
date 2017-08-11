<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    //
    //指定表名
    protected $table = 'cms_article';

    //指定主键
    protected $primaryKey ="id";

    //是否自动维护 create_at 和 updated_dt
    public  $timestamps = true;

    public function Remark()
    {
        return $this->hasMany('App\Http\Models\Remark','articleId');
    }

    public function ArticleClass()
    {
        return $this->belongsTo('App\Http\Models\ArticleClass','classId');
    }

    protected $hidden = [];

    static public function getDrafts($userId)
    {
        $sql ='select id value,title label,created_at time from cms_article where userId = ? and state =2 order by created_at DESC ';

        $ret = DB::select($sql,[$userId]);

        return $ret;
    }

    static public function getEditArticle($userId,$articleId)
    {
        $sql ='select * from cms_article where  id=? and userId = ?  limit 1 ';

        $ret = DB::select($sql,[$articleId,$userId]);

        return $ret;
    }

    static public function allArticles($page=1,$pageSize=25,$searchInfo='',$searchClass,$searchState)
    {
        $page=$page-1;
        $sql = "select a.id,a.title,a.thumbnail,a.title,a.created_at,a.updated_at,a.original,a.clickNum,a.state,
                        b.className,
                        c.name author from cms_article a,cms_article_class b,cms_user c where a.classId=b.id and a.userId = c.id ";


        if($searchInfo){
            $sql .=" and ( a.title like '%$searchInfo%' or c.name like '%$searchInfo%' ) ";
        }


        if($searchClass){
            $sql .=" and  a.classId = $searchClass";
        }
        if($searchState){
            $sql .=" and a.state=$searchState ";
        }

        $sql.=' order by a.state asc,a.created_at desc';
        $articles = DB::select($sql);

        $total = count($articles);

        $articles = array_splice($articles,$page*$pageSize,$pageSize);



        return ['total'=>$total,'articles'=>$articles];
    }

    static public function getTop($num=null)
    {
        $sql = 'select a.id,a.title,b.className,a.thumbnail,a.created_at,a.content from cms_article a,cms_article_class b where a.classId = b.id  and a.state=0 order by a.created_at desc';
        if($num){
            $sql.=" limit $num";
        }
        $ret = DB::select($sql);
        return $ret;
    }

    static public function getHot($num)
    {
        $sql = 'select  a.id,a.title,b.className,a.thumbnail,a.created_at,a.content from cms_article a,cms_article_class b where a.classId = b.id and a.thumbnail is not null and a.state=1 order by clickNum desc limit ?';

        $ret = DB::select($sql,[$num]);

        return $ret;
    }

    static public function getNew($num=1)
    {
        $sql = 'select a.id,a.title,b.className,a.thumbnail,a.created_at,a.content from cms_article a,cms_article_class b where a.classId = b.id  and (a.state=1 or a.state=0) order by a.created_at desc limit ?';
        $ret = DB::select($sql,[$num]);
        return $ret;
    }



}
