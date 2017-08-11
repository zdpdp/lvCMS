<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\_Function;
use App\Http\Models\Permission;
use App\Http\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest');
    }


    /*进入后台管理系统*/
    public function index(Request $request)
    {
        $userId = $request->session()->get('userId');

        $user = User::find($userId);

        /*获得站点基本信息*/

        /*获得用户可进入的后台模块*/
        $msg = User::getSideNav($userId);
        $function = User::getFunctionEnglishName($userId);
        return ['result'=>true,'msg'=>$msg,'head'=>$user->head,'name'=>$user->name,'power'=>$function];
    }

}