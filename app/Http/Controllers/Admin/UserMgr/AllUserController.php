<?php
namespace App\Http\Controllers\Admin\UserMgr;
use App\Http\Controllers\Controller;
use App\Http\Models\User;
use Illuminate\Http\Request;

class AllUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('UserGrageGuard')->except('index');
    }


    /**
     * 添加用户页面
     * @return options 用户可添加角色的选项
     *
     */
    public function index(Request $request)
    {
        $this->validate($request, [
           'page' => 'required',
           'pageSize' => 'required',
        ]);
        $page = $request->input('page');
        $pageSize = $request->input('pageSize');
        $searchInfo = $request->input('searchInfo');
        $searchRole = $request->input('searchRole');
        $searchState = $request->input('searchState');
        $users = User::getUserInfo($page,$pageSize,$searchInfo,$searchRole,$searchState);
        $roleOptions = User::getRoleOptions();

        return ['result'=>true,'users'=>$users,'roleOptions'=>$roleOptions];
    }

    public function editUser(Request $request)
    {
        $this->validate($request, [
            'editUser.id'=>'required|numeric',
            'editUser.account' => 'required|min:6|max:30|string',
            'editUser.password' => 'nullable|min:6|max:18|string',
            'editUser.name' => 'required|min:2|max:10|string',
            'editUser.role' => 'required|numeric',
            'editUser.state' => 'required|numeric',
        ]);

        $editUser = $request->input('editUser');

        $user = User::find($editUser['id']);

        if(!$user){
            return ['result'=>false,'该用户不存在,请刷新页面'];
        }

        $user->account=$editUser['account'];
        $user->name=$editUser['name'];
        if($editUser['password']){
            $user->password=$editUser['password'];
        }
        $user->role_id=$editUser['role'];
        $user->state=$editUser['state'];
        $ret = $user->save();

        if(!$ret){
            return ['result'=>false,'msg'=>'ERR01'];
        }

        return ['result'=>true,'msg'=>'编辑用户成功'];



    }

    public function deleteUser(Request $request)
    {
        $userId = $request->session()->get('userId');

        $alias = ['id'=>'user_id'];

        $this->getRules($alias)->check($request);

        $id = $request->input('id');

        if($id==$userId){
            return ['result'=>false,'msg'=>'无法删除自己'];
        }

        /*无法删除和自己同级或者更高级的用户*/

        $ret = User::destroy($id);

        if(!$ret)
            return ['result'=>false,'msg'=>'ERR01'];

        return ['result'=>true,'msg'=>'删除成功'];

    }

    public function batchChange(Request $request)
    {
        $this->validate($request, [
           'keyArr'=>'required|array',
            'state'=>'required|in:0,1,2,3'
        ]);

        $keyArr = $request->input('keyArr');
        $state = $request->input('state');
        $users = User::find($keyArr);
        foreach ($users as $val){
            $val->state = $state;
            $ret = $val->save();
            if(!$ret){
                return ['result'=>false,'msg'=>'ERRO1'];
            }
        }
        return ['result'=>true];
    }
    public function batchDelete(Request $request)
    {
        $this->validate($request, [
            'keyArr'=>'required|array'
        ]);

        $keyArr = $request->input('keyArr');

        $ret = User::destroy($keyArr);
        if(!$ret){
            return ['result'=>false,'msg'=>'ERRO1'];
        }
        return ['result'=>true];
    }

}