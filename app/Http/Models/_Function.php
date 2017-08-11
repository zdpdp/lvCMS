<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class _Function extends Model
{
    //
    //指定表名
    protected $table = 'cms_function';

    //指定主键
    protected $primaryKey ="id";

    //是否自动维护 create_at 和 updated_dt
    public  $timestamps = false;

    //protected $hidden = ['id'];

    protected $guarded = [];



}
