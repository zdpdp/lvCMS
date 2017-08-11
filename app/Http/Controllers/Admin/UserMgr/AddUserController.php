<?php
namespace App\Http\Controllers\Admin\UserMgr;

use App\Http\Controllers\Controller;
use App\Http\Models\User;
use Illuminate\Http\Request;

class AddUserController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest');
    }


    /**
     * 添加用户页面
     * @return options 用户可添加角色的选项
     *
     */
    public function index(Request $request)
    {
        $options = User::getRoleOptions();
        return ['result'=>true,'options'=>$options];

    }

    public function addOneUser(Request $request)
    {

        $this->validate($request, [
            'newUser.account' => 'required|min:6|max:30|string',
            'newUser.password' => 'required|min:6|max:18|string',
            'newUser.name' => 'required|min:2|max:10|string',
            'newUser.role' => 'required|numeric',
        ]);


        $getUser = $request->input('newUser');
        /*检测用户是否存在*/
        $ret = User::select()->where('account',$getUser['account'])->get();

        if(count($ret)>0){
            return ['result'=>false,'msg'=>'该账户已存在'];
        }

        $ip = $request->ip();
       $result =  User::addOneUser($getUser['account'],$getUser['password'],$getUser['name'],$getUser['role'],$ip);
       if(!$result){
           return ['result'=>false,'msg'=>$result['msg']];
       }

       return ['result'=>true,'msg'=>'新增用户成功'];


    }

}