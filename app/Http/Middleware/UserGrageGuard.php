<?php

namespace App\Http\Middleware;

use App\Http\Models\User;
use Closure;

class UserGrageGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //规定了提交的 是 id 或者 keyArr
        $my = User::current()->role;
        $id = $request->input('id');
        $keyArr = $request->input('keyArr');
        if($id){
            $user = User::find($id)->role;

            if($user->grade<=$my->grade){
                $ret = ['result'=>false,'msg'=>"无法操作同级别或更高级别的用户"];
                echo json_encode($ret);
                exit;
            }
        }else if($keyArr){
            $users = User::find($keyArr);

            foreach ($users as $val){
                if($val->role->grade<=$my->grade){
                    $ret = ['result'=>false,'msg'=>"无法操作同级别或更高级别的用户"];
                    echo json_encode($ret);
                    exit;
                }
            }
        }else{
            $ret = ['result'=>false,'msg'=>"ERR 未获得有效请求Id"];
            echo json_encode($ret);
            exit;
        }
        return $next($request);
    }
}
