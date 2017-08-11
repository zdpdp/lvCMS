<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Models\User;
use App\Http\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'account' => 'required',
            'password' => 'required',
        ]);

        $account = $request->input('account');

        $password = $request->input('password');

        $user =  User::where('account',$account)->where('password',$password)->first();

        if(count($user)==0)
        {
            return ['result'=>false,'msg'=>"账号或密码错误"];
        }
        else
        {
            if($user->state==1){
                return ['result'=>false,'msg'=>"该账户已被禁止登录"];
            }else if($user->state==3){
                return ['result'=>false,'msg'=>"该账户等待验证中"];

            }
            Visit::create(['time'=>date('Y-m-d H:i:s'),'type'=>1,'userId'=>$user->id,'ip'=>$request->ip()]);
            session(['account' => $user->account,'name'=>$user->name,'userId'=>$user->id]);
            return['result'=>true,'msg'=>'登录成功'];
        }

    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect()->route('login');
    }

    public function register(Request $request)
    {

    }

    public function resetPsw()
    {

    }


    public function forgetPsw()
    {

    }

    //    public function form(Request $request)
//    {
//        $this->validate($request, [
//            'name' => 'required|max:255',
//            'phone' => 'required',
//        ]);
//
//        return "ok";
//    }

}