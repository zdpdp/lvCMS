<?php
namespace App\Http\Controllers\Admin\ArticleMgr;

use App\Http\Controllers\Controller;
use App\Http\Models\Article;
use App\Http\Models\ArticleClass;
use App\Http\Models\Role;
use App\Http\Models\Site;
use App\Http\Models\User;
use Illuminate\Http\Request;

class AllArticleController extends Controller
{

    public function __construct()
    {
        //$this->middleware('Permit');
    }
    public function index(Request $request)
    {
       $alias = [
           'page'=>'page',
           'pageSize'=>'pageSize',
           'searchInfo'=>'searchInfo'
           ];

       $this->getRules($alias)->check($request);

        $page = $request->input('page');
        $pageSize = $request->input('pageSize');
        $searchInfo = $request->input('searchInfo');
        $searchClass = $request->input('searchClass');
        $searchState = $request->input('searchState');
        $articles  = Article::allArticles($page,$pageSize,$searchInfo,$searchClass,$searchState);
        $class = ArticleClass::all();

        return ['result'=>true,'articles'=>$articles['articles'],'total'=>$articles['total'],'class'=>$class];
    }
    public function delete(Request $request)
    {

        $this->validate($request, [
            'articleId' => 'required|numeric',
        ]);

        $articleId = $request->input('articleId');

        $ret = Article::destroy($articleId);

        if(!$ret){
            return ['result'=>false,'msg'=>'ERR01'];
        }
        return ['result'=>true];
    }
    public function recycleBin(Request $request)
    {

        $this->validate($request, [
            'articleId' => 'required|numeric',
        ]);

        $articleId = $request->input('articleId');

        $article = Article::find($articleId);

        $article->state=3;

        $ret = $article->save();

        if(!$ret){
            return ['result'=>false,'msg'=>'ERR01'];
        }
        return ['result'=>true];
    }
    public function back(Request $request)
    {
        $this->validate($request, [
            'articleId' => 'required|numeric',
        ]);

        $articleId = $request->input('articleId');

        $article = Article::find($articleId);

        $article->state=2;

        $ret = $article->save();

        if(!$ret){
            return ['result'=>false,'msg'=>'ERR01'];
        }
        return ['result'=>true];
    }
    public function up(Request $request)
    {
        $this->validate($request, [
            'articleId' => 'required|numeric',
        ]);

        $articleId = $request->input('articleId');

        $article = Article::find($articleId);

        $article->state=0;

        $ret = $article->save();

        if(!$ret){
            return ['result'=>false,'msg'=>'ERR01'];
        }
        return ['result'=>true];
    }
    public function down(Request $request)
    {
        $this->validate($request, [
            'articleId' => 'required|numeric',
        ]);

        $articleId = $request->input('articleId');

        $article = Article::find($articleId);

        $article->state=1;

        $ret = $article->save();

        if(!$ret){
            return ['result'=>false,'msg'=>'ERR01'];
        }
        return ['result'=>true];
    }
    public function batchDetele(Request $request)
    {
        $this->validate($request, [
            'keyArr'=>'required|array'
        ]);

        $keyArr = $request->input('keyArr');

        $ret = Article::destroy($keyArr);
        if(!$ret){
            return ['result'=>false,'msg'=>'ERRO1'];
        }
        return ['result'=>true];
    }
    public function batchChange(Request $request)
    {
        $this->validate($request, [
            'keyArr'=>'required|array',
            'state'=>'required|in:0,1,2,3'
        ]);

        $keyArr = $request->input('keyArr');
        $state = $request->input('state');
        $articles = Article::find($keyArr);
        foreach ($articles as $val){
            $val->state = $state;
            $ret = $val->save();
            if(!$ret){
                return ['result'=>false,'msg'=>'ERRO1'];
            }
        }
        return ['result'=>true];
    }





}