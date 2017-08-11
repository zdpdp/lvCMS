<?php
namespace App\Http\Controllers\Admin\SiteMgr;

use App\Http\Controllers\Controller;
use App\Http\Models\Role;
use App\Http\Models\Site;
use App\Http\Models\User;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{

    public function __construct()
    {
       // $this->middleware('Permit');
    }
    public function index()
    {
        $ret = [];

        $ret['result']=true;

        $ret['roleOption'] = Role::all();

        $ret['site'] = Site::find(1);

        return $ret;
    }

    /*修改*/
    public function set(Request $request)
    {

        $this->validate($request, [
            'site.name' => 'required|max:255',
            'site.openRegister' => 'required',
            'site.defaultRole' => 'required',
            //图片最大2M 2M = 2*1024*1024 KB 转换为base64 乘以4/3 等于2796203
            'icon'=>'nullable|max:2796203',
            'logo'=>'nullable|max:2796203',
        ]);
        $site = $request->input('site');



        $icon = $request->input('icon');
        $iconSql ="";

        if($icon){

            list($type, $data) = explode(',', $icon);
            // 判断类型
            if(strstr($type,'image/jpeg')!=''){
                $ext = '.jpg';
            }elseif(strstr($type,'image/x-icon')!=''){
                $ext = '.ico';
            }elseif(strstr($type,'image/png')!=''){
                $ext = '.png';
            }else{
                return ['result'=>false,'msg'=>"icon只能是jpg,ico,png文件"];
            }

            $iconImg = base64_decode($data);

            $fileName = "./images/siteImg/icon".time().$ext;

            $ret = file_put_contents($fileName, $iconImg);//返回的是字节数

            if(!$ret){
                return ['result'=>false,'msg'=>"保存icon文件失败"];
            }

            $iconSql = ",icon = '".substr($fileName,1)."'";

        }

        $logo = $request->input('logo');
        $logoSql ="";
        if($logo){

            list($type, $data) = explode(',', $logo);
            // 判断类型
            if(strstr($type,'image/jpeg')!=''){
                $ext = '.jpg';
            }elseif(strstr($type,'image/png')!=''){
                $ext = '.png';
            }else{
                return ['result'=>false,'msg'=>"logo只能是jpg,png文件"];
            }


            $logoImg = base64_decode($data);



            $fileName = "./images/siteImg/logo".time().$ext;

            $ret = file_put_contents($fileName, $logoImg);//返回的是字节数

            if(!$ret){
                return ['result'=>false,'msg'=>"保存logo文件失败"];
            }

            $logoSql = ",logo = '".substr($fileName,1)."'";
        }

        /*存入数据库*/
        $result = Site::updateSite($iconSql,$logoSql,$site);

        if($result=1)
            return ['result'=>true,'msg'=>"更新成功"];
        else
            return ['result'=>true,'msg'=>"更新失败"];
    }




}