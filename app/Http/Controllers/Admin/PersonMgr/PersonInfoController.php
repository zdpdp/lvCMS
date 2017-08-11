<?php
namespace App\Http\Controllers\Admin\PersonMgr;

use App\Http\Controllers\Controller;
use App\Http\Models\User;
use Illuminate\Http\Request;

class PersonInfoController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest');
    }


    /*获取基本资料*/
    public function index(Request $request)
    {
        $userId = $request->session()->get('userId');

        $ret = User::getBaseInfo($userId);

        return ['result'=>true,'userInfo'=>$ret[0]];
    }

    /*保存基本信息*/
    public function saveBase(Request $request)
    {
        $alias=[
            'userInfo.phone'=>'user_phone',
            'userInfo.email'=>'user_email',
            'userInfo.name'=>'user_name',
            'userInfo.birth'=>'user_bitrh',
            'userInfo.sex'=>'user_sex',
            'headPic'=>'user_head',
        ];
        $this->getRules($alias)->check($request);

        $userId = $request->session()->get('userId');
        $user = User::find($userId);

        $head = $request->input('headPic');
        $userInfo = $request->input('userInfo');

        if($head){

            list($type, $data) = explode(',', $head);
            // 判断类型
            if(strstr($type,'image/jpeg')!=''){
                $ext = '.jpg';
            }elseif(strstr($type,'image/png')!=''){
                $ext = '.png';
            }else{
                return ['result'=>false,'msg'=>"头像只能是jpg,png文件"];
            }

            $headImg = base64_decode($data);

            $fileName = "./images/userHead/".$userId.time().$ext;

            $ret = file_put_contents($fileName, $headImg);//返回的是字节数

            if(!$ret){
                return ['result'=>false,'msg'=>"保存头像文件失败"];
            }
            $user->head = substr($fileName,1);
        }

        $user->name=$userInfo['name'];
        $user->email=$userInfo['email'];
        $user->phone=$userInfo['phone'];
        $user->sex=$userInfo['sex'];
        if(isset($userInfo['birth'])){
            $user->birth=$userInfo['birth'];

        }

        $ret = $user->save();
        if(!$ret){
            return ['result'=>false,'msg'=>'保存基本信息失败'];
        }
        return ['result'=>true,'msg'=>'保存基本信息成功'];
    }

}