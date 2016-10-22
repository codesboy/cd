<?php
namespace app\index\model;

use think\Model;

// 用户信息模型
class UsersInfo extends Model
{
    protected $pk    = 'id';
    protected $type = [
        'addtime'    =>  'timestamp:Y-m-d',
        'birthday'    =>  'timestamp:Y-m-d'

    ];

    // 定义关联
    public function consumptions(){
        return $this->hasMany('Consumption','uid');
    }
}
