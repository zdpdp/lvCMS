<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class User extends Model
{
    /*
    定义存储时间的字段
     const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
    */

    //指定表名
    protected $table = 'cms_user';

    //指定主键
    protected $primaryKey ="id";

    //是否自动维护 create_at 和 updated_dt
    public  $timestamps = true;

    /*加密方式*/
    protected function encrypt($val)
    {
        return md5($val);
    }


    public function Role()
    {
        return $this->belongsTo('App\Http\Models\Role','role_id');
    }
    /**
     * 根据用户ID返回可进入的后台栏目
     * @param $userId
     */
    static public function getSideNav($userId)
    {
        $sql2 = "select * from cms_function  where id in (select function_id from cms_permission where role_id = (select role_id from cms_user where id = ?)) and grade in (1,2) order by grade asc";

        $ret = DB::select($sql2,[$userId]);

        $result = [];

        foreach ($ret as $key => $val)
        {
            if($val->grade==1)
            {
                $result[] =$val;
            }
            else
            {
                foreach ($result as $val2)
                {
                    if($val2->id==$val->father_id)
                    {
                        $val2->child[]=$val;
                        break;
                    }

                }
            }
        }
        return $result;
    }

    /**
     * @return bool 当前是否登录状态
     */
    static public function Auth()
    {
        $userId = Session::get('userId');
        if($userId)
            return true;
        else
            return false;
    }
    /**
     *获取当前登录用户 使用前要求必须登录
     */
    static public function current()
    {
        $userId = Session::get('userId');
        $user = User::find($userId);

        return $user;

    }
    /**
     * @param $userId
     * @return 用户所拥有的url权限数组
     */
    static public function getFunction($userId)
    {
        $sql = "select url from cms_function  where id in (select function_id from cms_permission where role_id = (select role_id from cms_user where id = ?)) and grade in (2,3)";

        $ret = DB::select($sql,[$userId]);

        $result = [];
        foreach ($ret as $val)
        {
            $result[] = $val->url;
        }

        return $result ;
    }
    static public function getFunctionEnglishName($userId)
    {
        $sql = "select EnglishName from cms_function  where id in (select function_id from cms_permission where role_id = (select role_id from cms_user where id = ?)) and grade in (2,3)";

        $ret = DB::select($sql,[$userId]);

        $result = [];
        foreach ($ret as $val)
        {
            $result[] = $val->EnglishName;
        }

        return $result ;
    }

    /*获取各角色人数*/
    static public function getRoleNum()
    {
        $sql ="select role_id,count(*) num from cms_user group by role_id";

        return DB::select($sql);
    }

    /*根据用户Id 获取级别低于他的角色信息*/
    static public function getRoleOptions()
    {
       // $sql = "select id,name from cms_role where  grade > (select grade from cms_role where id = (select role_id from cms_user where id = ?))";
        $sql = "select id,name,grade from cms_role order by grade ASC ";

        $result = DB::select($sql);

        $myGrade = User::current()->Role->grade;


        foreach ($result as $val)
        {
            if($val->grade<$myGrade)
                $val->disable = true;
            else
                $val->disable = false;
        }

        return $result;
    }

    /*添加单个用户*/
    static public function addOneUser($account,$password,$name,$role,$ip)
    {
        $newUser = new User();
        $newUser->account = $account;
        $newUser->name = $name;
        $newUser->password = $password;
        $newUser->role_id = $role;
        $newUser->register_ip = $ip;

        /*调用淘宝api获取注册地址*/
        /*

        $api ="http://ip.taobao.com/service/getIpInfo.php";

        $apiInfo = "$api?ip=$ip";

        $file_contents = file_get_contents($apiInfo) ;

        $addressInfo = json_decode($file_contents);

        if($addressInfo->code==1){
            return ['result'=>false,'msg'=>'获取IP地址失败'];
        }
        $addressInfo=$addressInfo->data;


        $newUser->register_address =$addressInfo->country." ".$addressInfo->region." ".$addressInfo->city;

        */
        $result = $newUser->save();
        if(!$result){
            return ['result'=>false,'msg'=>"注册失败ERR02"];
        }

        return ['result'=>true];
    }

    static public function getUserInfo($page=1,$pageSize=25,$searchInfo="",$searchRole,$searchState)
    {
        $page=$page-1;
        $sql = "select a.id,a.account,a.name,b.name role,a.role_id,a.state,a.created_at,a.register_address from cms_user a,cms_role b where a.role_id=b.id ";

        if($searchInfo){
            $sql .=" and ( a.account like '%$searchInfo%' or a.name like '%$searchInfo%' )";
        }

        if($searchRole){
            $sql .=" and  b.id = $searchRole";
        }
        if($searchState){
            $sql .=" and a.state=$searchState ";
        }
        $sql.=' order by b.grade asc';
        $users = DB::select($sql);

        $total = count($users);

        $users = array_splice($users,$page*$pageSize,$pageSize);

        return ['total'=>$total,'users'=>$users];
    }

    static public function getBaseInfo($userId)
    {
        $sql = 'select a.account,a.name,a.phone,a.head,a.sex,a.email,a.birth,b.name role from cms_user a,cms_role b where a.role_id = b.id and a.id = ?';

        $ret = DB::select($sql,[$userId]);

        return $ret;
    }
}
