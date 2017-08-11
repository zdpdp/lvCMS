<?php

namespace App\Http\Middleware;

use App\Http\Models\User;
use App\Http\Models\Visit;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class VisitHome
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

        $flag = $request->hasCookie('visit');
        if(!$flag){
            Cookie::queue('visit', true, 10);
            //增加一行访问记录
            Visit::create(['time'=>date('Y-m-d H:i:s'),'ip'=>$request->ip()]);
        }
        return $next($request);




    }
}
