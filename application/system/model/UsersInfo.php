<?php
namespace app\system\model;

use think\Model;

// 用户信息模型
class UsersInfo extends Model
{
    // 开启写入时间戳
    protected $autoWriteTimestamp = true;

    // 设置数据表主键,默认主键自动识别
    protected $pk    = 'id';
    protected $type = [
        'birthday'    =>  'timestamp:Y-m-d',
        'create_time'    =>  'timestamp',
        'update_time'    =>  'timestamp',
        'jz_time'    =>  'timestamp:Y-m-d'

    ];

    // 定义关联
    public function consumptions(){
        return $this->hasMany('Consumption','uid');


    }

    // sex读取器
    protected function getSexAttr($value)
    {
        $sex = [0=>'未知',1=>'男',2=>'女'];
        return $sex[$value];
    }

    // 年龄读取器
    protected function getAgeAttr($value,$data)
    {
        /*if($data['birthday']){

            return getAge(date('Y-m-d',$data['birthday']));
        }else{
            return $value;
        }*/
        return $data['birthday']?getAge(date('Y-m-d',$data['birthday'])):$value;
    }
}
