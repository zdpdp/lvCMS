<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Models\Article;
use App\Http\Models\ArticleClass;
use App\Http\Models\Remark;
use App\Http\Models\Resource;
use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
   {

       $topArticle = Article::getTop();

       $hotArticle = Article::getHot(4);

       $newArticle = Article::getNew(1);

       return view('home.index',['top'=>$topArticle,'hot'=>$hotArticle,'new'=>$newArticle]);
   }

   /*查看文章*/
   public function article($id)
   {


       $article = Article::find($id);
       $class = ArticleClass::find($article->classId);
       if($article->state!=1&&$article->state!=0){
           return '404';
       }
       $article->clickNum++;
       $article->save();
       $remarks = $article->remark->toArray();
       /*
        * 第一层评论 祖宗ID为空 父亲ID为空
        * 第二层评论 祖宗ID为第一层评论  父亲ID为空
        * 第三层评论 祖宗ID为第一层评论  父亲ID为第二层评论
        */
       $remark = [];
       foreach ($remarks as $key=>$val){
           if($val['userId']){
               $ret = User::find($val['userId']);
               $val['head']=$ret->head;
               $val['userName']=$ret->name;
           }else{
               $val['head']='';
               $val['userName']='';
           }
           if(!$val['tempName']){
               $val['tempName']='游客';
           }
           /*一层评论*/
           if($val['ancestor_id']==null){
               $val['index'] = count($remark)+1;
               $val['reply']='';
               $val['child']=[];
               $remark[$val['id']] = $val;
               continue;
           }

           /*二层评论*/
           if($val['father_id']==null){

               $val['index'] =  ($remark[$val['ancestor_id']]['index']).'-'.(count( $remark[$val['ancestor_id']]['child'])+1);
               $val['reply']='回复至'.$remark[$val['ancestor_id']]['index'].'楼';
               $remark[$val['ancestor_id']]['child'][] = $val;
               continue;

           }


           /*三层评论*/
           $val['index'] = ($remark[$val["ancestor_id"]]["index"]).'-'.(count( $remark[$val['ancestor_id']]['child'])+1);
           foreach ($remark[$val["ancestor_id"]]['child'] as $val2){
               if($val2["id"]==$val['father_id']){
                   $val['reply']='回复至'.$val2['index'].'楼';
               }
           }
           $remark[$val['ancestor_id']]['child'][] = $val;
       }
       $link = Resource::where(['type'=>1,'link_id'=>$article->id])->get();
       $user = User::find($article->userId);
       $relativeArticle = Article::where(['classId'=>$article->classId,'state'=>1])->take(5)->get();
       $hot = Article::getHot(3);
       return view('home.article',['article'=>$article,'user'=>$user,'relativeArticle'=>$relativeArticle,
                                     'hot'=>$hot,'link'=>$link,'remark'=>$remark,'className'=>$class->className,'classId'=>$class->id,
                                    'remarkable'=>$class->remarkable,'visitable'=>$class->visitable,'downloadable'=>$class->downloadable]);




   }

   /*前台发表评论*/
   public function addRemark(Request $request)
   {
       try {
           $articleId = $request->input('articleId');
           $userId = $request->session()->get('userId');
           $fatherId = $request->input('fatherId');
           $content = $request->input('content');
           $tempName = $request->input('tempName');
           if($userId){
               $user = User::find($userId);
               if($user->state==2){
                   return '该用户已被禁言';
               }
           }
           /*
                  * 第一层评论 祖宗ID为空 父亲ID为空
                  * 第二层评论 祖宗ID为第一层评论  父亲ID为空
                  * 第三层评论 祖宗ID为第一层评论  父亲ID为第二层评论
                  */
           $remark = new Remark();
           if (!$fatherId) {
               /*一级评论*/
               $remark->ancestor_id = null;
               $remark->father_id = null;
           } else {
               $father = Remark::find($fatherId);
               if (!$father->ancestor_id && !$father->father_id) {
                   /*父级评论是一级评论 新生成的评论应该为二级评论*/
                   $remark->ancestor_id = $fatherId;
                   $remark->father_id = null;
               } else {
                   /*父级评论是二/三级评论 新生成的评论应该为三级评论*/
                   $remark->ancestor_id = $father->ancestor_id;
                   $remark->father_id = $fatherId;
               }

           }
           if ($userId) {
               $remark->userId = $userId;
           }
           if($tempName){
               $remark->tempName = $tempName;

           }
           $remark->articleId = $articleId;
           $remark->content = $content;
           $ret = $remark->save();
           if (!$ret) {
               return '404';
           }
           return redirect('/article/' . $articleId);
       }catch (\Exception $e){
           return '500';
       }

   }

   /*类目页面*/
   public function articleClass($id,Request $request)
   {
       $page = $request->input('page')?:1;

       $class=ArticleClass::find($id);
       if(!$class){
           return '404';
       }
       $pageSize = 4;

       $ret = DB::table('cms_article')->where(['classId'=>$id,'state'=>0])->orWhere(['classId'=>$id,'state'=>1])->orderBy('created_at','desc')->paginate($pageSize);

       //相关类别
       if($class->fatherId){
           $relativeClass = ArticleClass::where('fatherId',$class->fatherId)->orWhere('id',$class->fatherId)->orderBy('fatherId','asc')->get();
       }else{
           $relativeClass = ArticleClass::where('fatherId',$id)->get();
       }

       return view('home.articleClass',['articles'=>$ret,'relativeClass'=>$relativeClass,'name'=>$class->className]);

   }

   /*下载文章附件*/
   public function download($id,Request $request)
   {
       $resource = Resource::find($id);
       if(!$resource){
           return '404';
       }
       $resource->downloadNum ++;
       $resource->save();
       $article = Article::find($resource->link_id);
       $class = ArticleClass::find($article->classId);
       $flag = $class->downloadable;
       if($flag==2){
           return '未开放下载该文件';
       }else if($flag==3){
           $ret = User::Auth();
           if(!$ret){
               return '登录后才可以下载该文件';
           }

       }
        $header = [
            'Content-type'=>'application/octet-stream',
            'Content-Disposition'=>'attachment;filename='.$resource->name,
            'Content-Length'=>filesize($resource->position)
        ];
        return response()->download($resource->position,$resource->name,$header);

   }

}