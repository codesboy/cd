<?php
namespace app\system\model;

use think\Model;

// 用户信息模型
class UsersTemp extends Model
{
    // 开启写入时间戳
    // protected $autoWriteTimestamp = true;

    // 设置数据表主键,默认主键自动识别
    // protected $pk    = 'id';
    protected $type = [
        // 'birthday'    =>  'timestamp:Y-m-d',
        // 'zxsj'    =>  'timestamp',
        // 'dzsj'    =>  'timestamp',
        // 'jz_time'    =>  'timestamp:Y-m-d'

    ];

    /*// 定义关联
    public function consumptions(){
        return $this->hasMany('Consumption','uid');


    }



    // 年龄读取器
    protected function getAgeAttr($value,$data)
    {
        return getAge(date('Y-m-d',$data['birthday']));
    }*/

    // sex读取器
    protected function getXbAttr($value)
    {
        $sex = [0=>'未知',1=>'男',2=>'女'];
        return $sex[$value];
    }
}
