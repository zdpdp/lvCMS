<?php

namespace App\Http\ViewComposers;

use App\Http\Models\ArticleClass;
use App\Http\Models\Friends;
use App\Http\Models\Site;
use App\Http\Models\Visit;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;


class homeComposer
{


    /**
     * 绑定数据到视图.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {

        //这里将使用redis缓存优化
        $site =Site::find(1);
        $friends = Friends::all();
        $class = ArticleClass::getClassTree();
        $login = Session::get('userId');
        $totalVisit = Visit::count();
        $view->with(['site'=>$site,'friends'=>$friends,'class'=>$class,'login'=>$login,'totalVisit'=>$totalVisit]);

    }
}