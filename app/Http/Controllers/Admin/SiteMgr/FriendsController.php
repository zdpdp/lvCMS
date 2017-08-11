<?php
namespace App\Http\Controllers\Admin\SiteMgr;

use App\Http\Controllers\Controller;
use App\Http\Models\Friends;
use App\Http\Models\Role;
use App\Http\Models\Site;
use App\Http\Models\User;
use Illuminate\Http\Request;

class FriendsController extends Controller
{

    public function __construct()
    {
       // $this->middleware('Permit');
    }
    public function index()
    {
       $ret = Friends::orderBy('top','desc')->get();

       return ['result'=>true,'friends'=>$ret];
    }
    public function add(Request $request)
    {
        $alias = [
            'friend.name'=>'friend_name',
            'friend.top'=>'friend_top',
            'friend.url'=>'friend.url'
        ];
        $this->getRules($alias)->check($request);

        $get = $request->input('friend');
        $friend = new Friends();
        $friend->name = $get['name'];
        $friend->url = $get['url'];
        $friend->top = $get['top'];
        $ret = $friend->save();
        if(!$ret){
            return ['result'=>false,'msg'=>'ERRO1'];
        }
        return ['result'=>true];
    }
    public function delete(Request $request)
    {
        $alias = [
            'id'=>'friend_id',
        ];
        $this->getRules($alias)->check($request);
        $id = $request->input('id');
        $ret =  Friends::destroy($id);
        if(!$ret){
            return ['result'=>false,'msg'=>'ERRO1'];
        }
        return ['result'=>true];

    }
    public function edit(Request $request)
    {
        $alias = [
            'friend.id'=>'friend_id',
            'friend.name'=>'friend_name',
            'friend.top'=>'friend_top',
            'friend.url'=>'friend.url'
        ];
        $this->getRules($alias)->check($request);
        $get = $request->input('friend');
        $friend = Friends::find($get['id']);
        $friend->name = $get['name'];
        $friend->url = $get['url'];
        $friend->top = $get['top'];
        $ret = $friend->save();
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
        $ret = Friends::destroy($keyArr);
        if(!$ret){
            return ['result'=>false,'msg'=>'ERRO1'];
        }
        return ['result'=>true];
    }

}