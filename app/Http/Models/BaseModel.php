<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{
    /**
     * @param $sql
     * @param null $arr
     * @return insert返回主键，delete返回影响条数，select返回资源数组，update返回影响条数
     */
    public function sqlexec ($sql, $arr=null)
    {
        try {
            $sql = trim($sql);

            $type = substr($sql,0,6);

            switch ($type) {
                case "insert":

                    if($arr)
                        DB::insert($sql, $arr);
                    else
                        DB::insert($sql);
                    $msg ="";
                    break;

                case "delete":

                    if($arr)
                        $msg =  DB::delete($sql, $arr);
                    else
                        $msg =  DB::delete($sql);

                    break;


                case "select":

                    if($arr)
                        $msg= DB::select($sql, $arr);
                    else
                        $msg= DB::select($sql);

                    break;


                case "update":

                    if($arr)
                        $msg = DB::update($sql, $arr);
                    else
                        $msg = DB::update($sql);

                    break;


                default:

                    throw new \Exception("wrong sql type");
            }

            return ['result'=>true,'msg'=>$msg];
        }catch(\Exception $e)
        {
            return ['result'=>false,'msg'=>$e->getMessage()];
        }
    }

}