<?php

namespace App\Http\Middleware;

use App\Http\Models\User;
use Closure;

class Permit
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
        if(!$userId){
            return ['result'=>false,'msg'=>'请先登录'];
        }
        $function = User::getFunction($userId);

       $currentRoute = '/'.$request->path();

        $entry = in_array($currentRoute,$function);

//       echo $currentRoute;
//       var_dump($function);
//       exit;

       if($entry){
           return $next($request);
       }

        $ret = ['result'=>false,'msg'=>"无权限"];
        echo json_encode($ret);
        exit;
    }
}
