<?php
namespace App\Http\Controllers\Admin\ArticleMgr;

use App\Http\Controllers\Controller;
use App\Http\Models\ArticleClass;
use App\Http\Models\Remark;
use App\Http\Models\User;
use Illuminate\Http\Request;

class RemarkMgrController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest');
    }


    /*获取评论信息*/
    public function index(Request $request)
    {
        $alias = [
            'page'=>'page',
            'pageSize'=>'pageSize',
            'searchInfo'=>'searchInfo',
            'type'=>'remark_searchType'
        ];
        $this->getRules($alias)->check($request);

        $page = $request->input('page');
        $pageSize = $request->input('pageSize');
        $searchInfo = $request->input('searchInfo');
        $type = $request->input('type');

        $ret = Remark::getRemarks($page,$pageSize,$searchInfo,$type);
        return $ret;
    }

    public function reply(Request $request)
    {
        $alias = [
            'id'=>'remark_id',
            'content'=>'remark_content',
        ];
        $this->getRules($alias)->check($request);

        $userId = $request->session()->get('userId');
        $id = $request->input('id');
        $content = $request->input('content');
        /*
       * 第一层评论 祖宗ID为空 父亲ID为空
       * 第二层评论 祖宗ID为第一层评论  父亲ID为空
       * 第三层评论 祖宗ID为第一层评论  父亲ID为第二层评论
       */
        $remark = new Remark();

        $father = Remark::find($id);

        if (!$father->ancestor_id && !$father->father_id) {
            /*父级评论是一级评论 新生成的评论应该为二级评论*/
            $remark->ancestor_id = $id;
            $remark->father_id = null;
        } else {
            /*父级评论是二/三级评论 新生成的评论应该为三级评论*/
            $remark->ancestor_id = $father->ancestor_id;
            $remark->father_id = $id;
        }

        $remark->userId = $userId;

        $remark->articleId = $father->articleId;
        $remark->content = $content;
        $ret = $remark->save();
        if (!$ret) {
            return ['result'=>false,'msg'=>'ERRO1'];
        }
        return ['result'=>true];
    }

    public function delete(Request $request)
    {
        $alias = [
            'id'=>'remark_id',
        ];
        $this->getRules($alias)->check($request);
        $id = $request->input('id');
        $ret = Remark::destroy($id);
        if(!$ret){
            return ['result'=>false,'msg'=>'ERRO1'];
        }
        return ['result'=>true];
    }

    public function edit(Request $request)
    {
        $alias = [
            'id'=>'remark_id',
            'content'=>'remark_content',
        ];
        $this->getRules($alias)->check($request);
        $id = $request->input('id');
        $content = $request->input('content');
        $remark = Remark::find($id);
        $remark->content = $content;
        $ret = $remark->save();
        if(!$ret){
            return ['result'=>false,'msg'=>'ERRO1'];
        }
        return ['result'=>true];
    }
    public function recover(Request $request)
    {
        $alias = [
            'id'=>'remark_id',
        ];
        $this->getRules($alias)->check($request);
        $id = $request->input('id');
        $remark = Remark::find($id);
        $remark->state = 1;
        $ret = $remark->save();
        if(!$ret){
            return ['result'=>false,'msg'=>'ERRO1'];
        }
        return ['result'=>true];
    }

    public function batchDelete(Request $request)
    {

        $this->validate($request, [
            'keyArr'=>'required|array'
        ]);

        $keyArr = $request->input('keyArr');

        $ret = Remark::destroy($keyArr);
        if(!$ret){
            return ['result'=>false,'msg'=>'ERRO1'];
        }
        return ['result'=>true];
    }




}