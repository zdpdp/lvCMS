<?php
namespace App\Http\Controllers\Admin\ArticleMgr;

use App\Http\Controllers\Controller;
use App\Http\Models\Article;
use App\Http\Models\ArticleClass;
use App\Http\Models\Resource;
use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddArticleController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest');
    }


    /**/
    public function index(Request $request)
    {
       $class = ArticleClass::select(['id as value','className as label','fatherId','remarkable','visitable','downloadable'])->get()->toArray();

        $ret = [];
        foreach ($class as $val)
        {
            if($val['fatherId']==null){
                $val['children']=[];
                $ret[$val['value']] = $val;
                continue;
            }
            $ret[$val['fatherId']]['children'][]=$val;
        }

        $ret = array_merge($ret,[]);

        $userId = $request->session()->get('userId');
        $drafts = Article::getDrafts($userId);
       return ['result'=>true,'classOptions'=>$ret,'drafts'=>$drafts];

    }

    /*接受附件*/
    public function attach(Request $request)
    {
       // return ['result'=>false,'msg'=>'禁止上传附件'];
        $maxSize = 10*1024*1024; //10MB 最大

        $file = $_FILES['file'];

        $name = $file['name'];
        $size = $file['size'];
        $tempName = $file['tmp_name'];
        if(!is_uploaded_file($tempName)){
            return ['reuslt'=>false,'msg'=>'ERR01'];
        }
        $arr = explode('.',$name);
        $ext = end($arr); //文件后缀
        if($size>$maxSize){
            return ['reuslt'=>false,'msg'=>"超过了最大附件大小 $maxSize/1024/1024 kb",'size'=>$file['size']];
        }

        $saveDir = date("Ymd");
        $dir = './../resources/attachment/'.$saveDir;
        if(!is_dir($dir))
        {
            if (!mkdir($dir, 0600)) {
                return ['result'=>false,'msg'=>'ERRO2'];
            }
            //linux下运行以下代码  保证文件夹无执行权限 防止用户上传恶意执行文件
            chmod($dir,'0600');
        }

        $userId = $request->session()->get('userId');
        $saveName =$dir.'/'.$userId.time().'.'.$ext;

        $ret = move_uploaded_file($tempName,$saveName);
        if(!$ret){
            return ['result'=>false,'msg'=>'ERR03'];
        }

        return ['result'=>true,'file'=>substr($saveName,1)];


    }

    /*发表文章和保存草稿*/
    public function publicArticle(Request $request)
    {
        $alias = [
            'article.name'=>'article_name',
            'class'=>'article_class',
            'article.content'=>'article_content',
            'article.draft'=>'article_draft',
            'article.source'=>'article_source',
            'article.original'=>'article_original',
            'thumbnail'=>'article_thumbnail',
        ];

        $list = $request->input('list');
        $articleInfo = $request->input('article');
        $thumbnail = $request->input('thumbnail');
        $class=$request->input('class');

        $userId=$request->session()->get('userId');
        if($userId){
            $user = User::find($userId);
            if($user->state==2){
                return ['result'=>false,'msg'=>"该用户已被禁言"];
            }
        }

        DB::beginTransaction();
        try{
            $article = new Article();
            if($thumbnail){

                list($type, $data) = explode(',', $thumbnail);
                // 判断类型
                if(strstr($type,'image/jpeg')!=''){
                    $ext = '.jpg';
                }elseif(strstr($type,'image/png')!=''){
                    $ext = '.png';
                }else{
                    return ['result'=>false,'msg'=>"缩略图只能是jpg,png文件"];
                }

                $thumbnailImg = base64_decode($data);

                $fileName = "./images/articleImg/".$userId.time().$ext;

                $ret = file_put_contents($fileName, $thumbnailImg);//返回的是字节数

                if(!$ret){
                    return ['result'=>false,'msg'=>"保存缩略图失败"];
                }
                $article->thumbnail = substr($fileName,1);
            }
            $msg = '';
            $type = '';
            $article->userId = $userId;
            $article->title = $articleInfo['name'];
            $article->classId = $class;
            $article->content = $articleInfo['content']?:'';
            $article->original = $articleInfo['original'];
            if(!$article->original){
                $article->source = $articleInfo['source'];
            }
            if($articleInfo['draft']){
                $article->state = 2;
                $msg = '保存草稿成功';
                $type = 'saveDraft';
            }else{
                $article->state = 1;
                $msg ='发布文章成功';
                $msg = 'publicArticle';
            }
            $ret = $article->save();
            if(!$ret){
                DB::rollBack();
                return ['result'=>false,'msg'=>'ERR01'];
            }

            if($list){
                foreach ($list as $val){
                    Resource::create(['type'=>1,'link_id'=>$article->id,'name'=>$val['name'],'position'=>$val['url']]);
                }
            }
            DB::commit();
            return ['result'=>true,'msg'=>$msg,'type'=>$type,'id'=>$article->id];
        }catch(\Exception $e){
            DB::rollBack();
            return ['result'=>false,'msg'=>$e->getMessage()];
        }
    }

    /*二次编辑文章或草稿*/
    public function editArticle(Request $request)
    {
        date_default_timezone_set("Asia/Shanghai");

        $alias = [

            'class'=>'article_class',
            'article.name'=>'article_name',
            'article.content'=>'article_content',
            'article.draft'=>'article_draft',
            'article.source'=>'article_source',
            'article.original'=>'article_original',
            'thumbnail'=>'article_thumbnail',
            'editId'=>'article_id',

        ];
        $this->getRules($alias)->check($request);
        $editId = $request->input('editId');
        $class = $request->input('class');
        $articleInfo = $request->input('article');
        $thumbnail = $request->input('thumbnail');
        $list = $request->input('list');
        $userId= $request->session()->get('userId');
        $msg = '';
        $type = '';
        try{
            $article = Article::find($editId);
            if($article->userId != $userId){
                return ['result'=>false,'msg'=>'你无权修改其他人文章'];
            }

            if($thumbnail){

                list($type, $data) = explode(',', $thumbnail);
                // 判断类型
                if(strstr($type,'image/jpeg')!=''){
                    $ext = '.jpg';
                }elseif(strstr($type,'image/png')!=''){
                    $ext = '.png';
                }else{
                    return ['result'=>false,'msg'=>"缩略图只能是jpg,png文件"];
                }

                $thumbnailImg = base64_decode($data);

                $fileName = "./images/articleImg/".$userId.time().$ext;

                $ret = file_put_contents($fileName, $thumbnailImg);//返回的是字节数

                if(!$ret){
                    return ['result'=>false,'msg'=>"保存缩略图失败"];
                }
                $article->thumbnail = substr($fileName,1);
            }
            $article->title = $articleInfo['name'];
            $article->classId = $class;
            $article->content = $articleInfo['content']?:'';
            $article->original = $articleInfo['original'];
            if(!$article->original){
                $article->source = $articleInfo['source'];
            }
            if($articleInfo['draft']){
                //要保存为草稿
                $article->state = 2;
                $msg = '保存草稿成功';
                $type ='saveDraft';
            }else{
                //要正式发布
                $msg = '修改文章成功';
                $type = 'editArticle';

                if($article->state==2){
                    $msg = '发布文章成功';
                    $type = 'publicDraft';
                    $article->created_at = date('Y-m-d H:i:s');
                }

                $article->state = 1;
            }
            $article->save();
            if($list){
                Resource::where('type',1)->where('link_id',$article->id)->delete();
                foreach ($list as $val){
                    Resource::create(['type'=>1,'link_id'=>$article->id,'name'=>$val['name'],'position'=>$val['url']]);
                }
            }
            DB::beginTransaction();
            return ['result'=>true,'msg'=>$msg,'type'=>$type,'id'=>$article->id];
        }catch(\Exception $e){
            DB::rollBack();
            return ['result'=>false,'msg'=>$e->getMessage()];
        }

    }
    /*获取编辑文章的信息*/
    public function getEditInfo(Request $request)
    {
        $alias = ['articleId'=>'article_id'];
        $this->getRules($alias)->check($request);
        $articleId = $request->input('articleId');
        $userId = $request->session()->get('userId');

        $ret = Article::getEditArticle($userId,$articleId);
        $list = Resource::getAttachment($articleId);

        if(!$ret){
            return ['result'=>false,'msg'=>'未找到该文章信息'];
        }
        $ret=$ret[0];

        /*element ui的级联选择器必须要有父级的ID，因此需要以数组形式返回*/
        $class = ArticleClass::find($ret->classId);
        $ret->classId = [$ret->classId];
        if($class->fatherId){
            array_unshift($ret->classId,$class->fatherId);
        }
        return ['result'=>true,'editArticleInfo'=>$ret,'list'=>$list];
    }
}