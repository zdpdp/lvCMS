<?php
namespace App\Http\Controllers\Admin\VisitMgr;
use App\Http\Controllers\Controller;
use App\Http\Models\User;
use App\Http\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitCountController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest');
    }


    public function index(Request $request)
    {

        DB::connection()->enableQueryLog();
        $this->validate($request, [
            'type'=>'required|numeric|in:0,1,2',
            'toDate'=>'nullable|numeric',
            'number'=>'nullable|numeric',
        ]);

        $type = $request->input('type')?:0;
        $toDate = $request->input('toDate')?:time();
        $number = $request->input('number')?:7;
        $result = Visit::staticCount($type,$toDate,$number);
//        $a = DB::getQueryLog();
//        dd($a);
//        exit;

        $base = 24*60*60;
        $retVisit=[];
        $retLogin=[];
        if($type==0){
            //日
            while($number>0){
                $number--;
                $name =date('Y/m/d',$toDate-$number*$base);
                $retVisit[$name]=0;
                $retLogin[$name]=0;
                foreach ($result as $val){
                    if($val->name==$name){
                        if($val->type==0){
                            $retVisit[$name]=$val->count;
                        }else{
                            $retLogin[$name]=$val->count;
                        }

                    }
                }
                if(count($result)==0){
                    $retVisit[$name]=0;
                    $retLogin[$name]=0;
                }
            }

        }else if($type==1){
            $base*=31;
            while($number>0) {
                $number--;
                $name = date('Y/m', $toDate - $number * $base);
                $retVisit[$name]=0;
                $retLogin[$name]=0;
                foreach ($result as $val) {
                    if($val->name==$name.'/01'){
                        if($val->type==0){
                            $retVisit[$name]=$val->count;
                        }else{
                            $retLogin[$name]=$val->count;
                        }

                    }
                }
                if(count($result)==0){
                    $retVisit[$name]=0;
                    $retLogin[$name]=0;
                }


            }

        }else if($type==2){
            $base*=365;
            while($number>0) {
                $number--;
                $name = date('Y', $toDate - $number * $base);
                $retVisit[$name]=0;
                $retLogin[$name]=0;
                foreach ($result as $val) {
                    if($val->name==$name.'/01/01'){
                        if($val->type==0){
                            $retVisit[$name]=$val->count;
                        }else{
                            $retLogin[$name]=$val->count;
                        }

                    }
                }
                if(count($result)==0){
                    $retVisit[$name]=0;
                    $retLogin[$name]=0;
                }
            }
        }

        return ['result'=>true,'visit'=>$retVisit,'login'=>$retLogin] ;
    }


}