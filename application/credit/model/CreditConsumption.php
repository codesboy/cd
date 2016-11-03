<?php
namespace app\credit\model;

use think\Model;

class CreditConsumption extends Model
{
    protected $autoWriteTimestamp = true;
    protected $type = [
        'pay_time'  =>  'timestamp:Y-m-d',
        'create_time'  =>  'timestamp:Y-m-d',
    ];

    // 定义关联 一个客户下有多条积分记录
    public function creditConsumptions()
    {
        return $this->belongsTo('CreditUsers');
    }

}