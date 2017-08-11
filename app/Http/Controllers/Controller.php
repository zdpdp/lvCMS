<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*这里添加所有的验证规则，统一用一套*/
    protected $standard=[

        'page'=>'nullable|numeric|min:1',
        'pageSize'=>'nullable|numeric|min:1',
        'searchInfo'=>'nullable|string|max:50',


        'user_id'=> 'required|numeric',
        'user_name'=>'required|min:2|max:30|string',
        'user_account'=>'required|min:6|max:30|string',
        'user_password'=>'min:6|max:18|string',
        'user_state'=>'required|numeric|in:0,1,2,3',
        'user_sex'=>'required|in:1,2,3',
        'user_phone'=>'nullable|regex:/^1[34578][0-9]{9}$/',
        'user_bitrh'=>'nullable|date',
        'user_head'=>'nullable|max:2796203',
        'user_email'=>'nullable|email',

        'class_id'=>'required|numeric',
        'class_remarkable'=>'required|numeric|in:1,2,3',
        'class_visitable'=>'required|numeric|in:1,2,3',
        'class_downloadable'=>'required|numeric|in:1,2,3',
        'class_name'=>'required|unique:cms_article_class,className|min:2|max:15',

        'article_id'=>'required|numeric|exists:cms_article,id',
        'article_name'=>'required|string|min:1|max:50',
        'article_class'=>'nullable|numeric|exists:cms_article_class,id',
        'article_thumbnail'=>'nullable|max:69905075|string',
        'article_content'=>'nullable|string',
        'article_draft'=>'required|numeric|in:0,1',
        'article_source'=>'nullable|string|max:50',
        'article_original'=>'required|numeric|in:0,1',

        'friend_id'=>'required|numeric|exists:cms_friends,id',
        'friend_name'=>'required|string|min:1|max:30',
        'friend_url'=>'required|string|url',
        'friend_top'=>'required|numeric|in:0,1',

        'remark_searchType'=>'required|numeric|in:0,1,2,3,4',
        'remark_id'=>'required|numeric|exists:cms_remark,id',
        'remark_content'=>'required|string|min:1',

        'role_id'=>'',
        'role_grade'=>'',
        'role_name'=>'',
    ];

    protected $rules=[];

    /**
     * @param $alias
     * @param array $extra
     * @return $this extra 额外规则可以覆盖默认规则
     */
    public function getRules($alias,$extra=[])
    {
        $this->rules=[];

        foreach ($alias as $key=>$val)
        {

            if (array_key_exists($val, $this->standard))
            {
                $this->rules[$key]=$this->standard[$val];
            }
        }

        $this->rules = array_merge($this->rules,$extra);


        return $this;
    }

    public function check(Request $request)
    {
        $this->validate($request,$this->rules);
    }


}
