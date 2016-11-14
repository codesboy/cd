<?php
namespace app\credit\model;

use think\Model;

class CreditUsers extends Model
{
    protected $autoWriteTimestamp = true;
    protected $type = [
        'pay_time'  =>  'timestamp:Y-m-d',
        'create_time'  =>  'timestamp:Y-m-d H:i:s',
    ];

    // 定义关联 一个客户下有多条积分记录
    public function creditConsumptions()
    {
        return $this->hasMany('CreditConsumption','uid');
    }

    // sex读取器
    protected function getSexAttr($value)
    {
        $sex = [0=>'未知',1=>'男',2=>'女'];
        return $sex[$value];
    }

}
