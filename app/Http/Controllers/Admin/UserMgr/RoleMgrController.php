<?php
namespace App\Http\Controllers\Admin\UserMgr;

use App\Http\Controllers\Controller;
use App\Http\Models\_Function;
use App\Http\Models\Permission;
use App\Http\Models\Role;
use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleMgrController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest');
    }



    public function index()
    {
        $roleInfo = Role::getAllRoleInfo();

        $roleNum = User::getRoleNum();

        $functionInfo = _Function::select('id','name as label','father_id','grade')->orderBy('grade', 'asc')->get()->toArray();

        $function =[];

        /*所有功能权限转树形结构*/
        foreach ($functionInfo as $val)
        {

            if($val['father_id']==null){
                $function[$val['id']] = $val;
                $function[$val['id']]['children']=[];
                continue;
            }
            if($val['grade']==2){
                $function[$val['father_id']]['children'][$val['id']]=$val;
                $function[$val['father_id']]['children'][$val['id']]['children']=[];
                continue;
            }
            if($val['grade']==3){
                foreach ($function as &$val2){
                    if(array_key_exists($val['father_id'],$val2['children'])){
                        $val2['children'][$val['father_id']]['children'][]=$val;
                    }
                }
            }
        }


        /*由于索引不是从0开始 JS会当作对象处理，因此需要重建索引*/
        $function = array_merge($function);
        foreach ($function as &$val1){
            if(isset($val1['children'] )){
                $val1['children'] = array_values( $val1['children']);
            }
            foreach ($val1 as &$val2){
                if(isset($val2['children'] )){
                    $val2['children'] = array_values( $val2['children']);
                }
            }

        }


        /*各角色人数赋值*/
        foreach ($roleInfo as $val)
        {
            foreach ($roleNum as $num)
            {
                if($num->role_id==$val->role_id)
                {
                    $val->num =$num->num;
                    break;
                }
            }

        }

        return ['result'=>true,'msg'=>$roleInfo,'_function'=>$function];

    }

    public function newRole(Request $request)
    {
        $this->validate($request, [
            'newRole.name' => 'required|max:255',
            'newRole.grade' => 'required|numeric|min:1|max:10',
        ]);
        $getRole = $request->input('newRole');

        $grade = $getRole['grade'];
        $find = Role::where('name',$getRole['name'])->get()->toArray();
        if($find){
            return ['result'=>false,'msg'=>'已存在该角色名'];
        }
        DB::beginTransaction();
        try{
            $newRole = new Role();
            $newRole->name=$getRole['name'];
            $newRole->grade=$getRole['grade'];
            $newRole->ifDefault=0;
            $newRole->save();
            /*为新角色创建权限 参考同级别角色*/
            $ret =  Role::cratePermitssion($getRole,$newRole->id);
            if(!$ret){
                DB::rollBack();
                return ['result'=>false,'msg'=>'ERROR:001'];
            }
            DB::commit();
            return ['result'=>true,'msg'=>"创建角色成功",'newRole'=>$newRole];
        }catch (\Exception $e){
            DB::rollBack();
            return ['result'=>false,'msg'=>$e->getMessage()];
        }



    }

    public function getRolePermission(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required|numeric|min:1',
        ]);
        $role_id = $request->input('role_id');

        $result = Permission::select('function_id as id')->where('role_id',$role_id)->get();

        $permissionId = [];
        foreach ($result as $val){
            $permissionId[] = $val['id'];
        }
        return ['result'=>'true','permissionId'=>$permissionId];
    }

    public function deleteRole(Request $request)
    {
        $this->validate($request, [
            'role_id'=>'required|numeric'
        ]);
        $role_id = $request->input("role_id");
        DB::beginTransaction();
        try{

            Role::destroy($role_id);
            DB::commit();
            return ['result'=>true];
        }catch(\Exception $e){
            DB::rollBack();
            return ['result'=>false,'msg'=>$e->getMessage()];
        }

    }

    public function editRolePemition(Request $request)
    {

        $this->validate($request, [
            'permissionArr' => 'nullable|array|',
            'role_id'=>'required|numeric'
        ]);
        $permissionArr = $request->input('permissionArr');
        $role_id = $request->input("role_id");
        DB::beginTransaction();
        try{
            Permission::where('role_id',$role_id)->delete();
            foreach ($permissionArr as $val){
                Permission::create(['role_id'=>$role_id,'function_id'=>$val]);
            }
            DB::commit();
            return ['result'=>true];
        }catch(\Exception $e){
            DB::rollBack();
            return ['result'=>false,'msg'=>$e->getMessage()];
        }

    }

    public function editRoleBaseInfo(Request $request)
    {
        $this->validate($request, [
            'roleBaseInfo.role_id'=>'required|numeric',
            'roleBaseInfo.name'=>'required|max:255',
            'roleBaseInfo.grade'=>'required|numeric'
        ]);

        $roleBaseInfo = $request->input("roleBaseInfo");

        DB::beginTransaction();
        try{
            $role = Role::find($roleBaseInfo['role_id']);
            $role->name = $roleBaseInfo['name'];
            $role->grade = $roleBaseInfo['grade'];
            $role->save();
            DB::commit();
            return ['result'=>true];
        }catch(\Exception $e){
            DB::rollBack();
            return ['result'=>false,'msg'=>$e->getMessage()];
        }

    }

}