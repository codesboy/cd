<?php
namespace app\index\model;

use think\Model;

class Consumption extends Model{
    protected $type       = [
        'jz_time'    =>  'timestamp:Y-m-d',
        'create_time'  =>  'timestamp:Y-m-d H:i:s'
    ];

    // 开启自动写入时间戳protected
    protected $autoWriteTimestamp = true;

    // 定义自动完成的属性protected $insert = ['status' => 1];

    // 定义关联方法
    public function usersinfo(){
        return $this->belongsTo('UsersInfo');
    }

}
