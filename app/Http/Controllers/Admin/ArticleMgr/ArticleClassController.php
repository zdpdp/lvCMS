<?php
namespace App\Http\Controllers\Admin\ArticleMgr;

use App\Http\Controllers\Controller;
use App\Http\Models\ArticleClass;
use App\Http\Models\User;
use Illuminate\Http\Request;

class ArticleClassController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest');
    }


    /*获取文章类别*/
    public function index(Request $request)
    {
       $classRet = ArticleClass::getClassInfo();
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
        return ['result'=>true,'msg'=>$ret];
    }

    /*添加一级类别和二级类别*/
    public function addClass(Request $request)
    {
        $alias=['className'=>'class_name'];

        $extra=['fatherId'=>'nullable|numeric'];

        $this->getRules($alias,$extra)->check($request);

        $name = $request->input('className');

        $fatherId = $request->input('fatherId');


        $newClass = new ArticleClass();
        $newClass->className = $name;
        if($fatherId){
           $ret= ArticleClass::find($fatherId);
           if($ret->fatherId!=null){
               return ['result'=>false,'msg'=>'父类别只允许是一级类别'];
           }
            $newClass->fatherId = $fatherId;
        }
        $ret = $newClass->save();
        if(!$ret){
            return ['result'=>false,'msg'=>'ERRP1'];
        }
        $result = ['id'=>$newClass->id,'fatherId'=>null,'sum'=>0,'child'=>[],'className'=>$name];

        return ['result'=>true,'msg'=>$result];
    }

    /*删除类别*/
    public function deleteClass(Request $request)
    {
        $alias = ['classId'=>'class_id'];

        $this->getRules($alias)->check($request);

        $classId = $request->input('classId');

        $ret = ArticleClass::destroy($classId);

        if(!$ret){
            return ['result'=>false,'msg'=>'ERR01'];
        }

        return ['result'=>true];

    }
    /*编辑类别*/
    public function editClass(Request $request)
    {
        $alias=[
            'editRow.classId'=>'class_id',
            'editRow.remarkable'=>'class_remarkable',
            'editRow.visitable'=>'class_visitable',
            'editRow.downloadable'=>'class_downloadable',
        ];
        $extra=[
            'editRow.className'=>'required|min:2|max:15',
        ];
        $this->getRules($alias,$extra)->check($request);

        $editRow = $request->input('editRow');

        /*修改的类别名查找是否已存在*/
        $class = ArticleClass::editClass($editRow);

        return $class;
    }

}