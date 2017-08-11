<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticleClass extends Model
{
    //
    //指定表名
    protected $table = 'cms_article_class';

    //指定主键
    protected $primaryKey ="id";

    //是否自动维护 create_at 和 updated_dt
    public  $timestamps = false;

    //protected $hidden = ['id'];

    protected $guarded = [];

    static public function getClassInfo()
    {
        $sql1 = 'select classId,count(id) sum from cms_article GROUP BY classId';

        $sql2 = 'select id,fatherId,className,0 sum,remarkable,visitable,downloadable from cms_article_class';

        $articleNum = DB::select($sql1);

        $classRet = DB::select($sql2);

        foreach ($classRet as $val)
        {
            foreach ($articleNum as $val2)
            {
                if($val2->classId == $val->id){
                    $val->sum=$val2->sum;
                    break;
                }
            }

        }

        return $classRet;

    }

    static public function editClass($editRow)
    {
        $sql ='select id from cms_article_class where className=? and id!=?';

        $ret1 = DB::select($sql,[$editRow['className'],$editRow['classId']]);

        if(count($ret1)>0){
            return ['result'=>false,'msg'=>'修改的类别名已存在'];
        }

        $class = ArticleClass::find($editRow['classId']);

        $class->className = $editRow['className'];
        $class->remarkable = $editRow['remarkable'];
        $class->visitable = $editRow['visitable'];
        $class->downloadable = $editRow['downloadable'];
        $ret2= $class->save();
        if(!$ret2){
            return ['result'=>false,'msg'=>'ERRO1'];
        }
        return ['result'=>true];
    }


    static public function getClassTree()
    {
        $sql = 'select id,fatherId,className,remarkable,visitable,downloadable from cms_article_class';
        $classRet = DB::select($sql);
        $ret = [];
        foreach ($classRet as $val)
        {
            if($val->fatherId==null){
                $val->child=[];
                $ret[$val->id] = $val;
                continue;
            }
            $ret[$val->fatherId]->child[]=$val;
        }
        $ret = array_merge($ret,[]);
        return $ret;
    }
}
