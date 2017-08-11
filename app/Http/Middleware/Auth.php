<?php

namespace App\Http\Middleware;

use App\Http\Models\User;
use Closure;

class Auth
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
        $userId = $request->session()->get('userId');

        if($userId)
            return $next($request);

        if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
            // ajax 请求的处理方式

            $ret = ['result'=>false,'msg'=>"请先登录"];
            echo json_encode($ret);
            exit;
        }else{
            // 正常请求的处理方式
            return redirect()->route('login');
        };

    }
}
