<?php
namespace app\index\model;

use think\Model;

// 用户信息模型
class UsersInfo extends Model
{
    // 设置数据表主键,默认主键自动识别
    protected $pk    = 'id';
    protected $type = [
        'addtime'    =>  'timestamp',
        'birthday'    =>  'timestamp:Y-m-d'

    ];

    // 定义关联
    public function consumptions(){
        return $this->hasMany('Consumption','uid');
    }
}
