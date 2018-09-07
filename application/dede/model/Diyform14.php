<?php
namespace app\dede\model;

use think\Model;

class Diyform14 extends Model
{
    public static function getUserByTel($tel){
        $user=self::where('tel',$tel)->find();//查询数据

        // dump(config('setting.img_prefix'));
        return $user;
    }
}