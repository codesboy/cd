<?php
namespace app\common\validate;

use think\Validate;

class User extends Validate
{   
    protected $rule = [
        'username'  =>  'require|max:25',
        'age' =>  'number|between:1,120',
        'sex' =>  'number',
        'tel' =>  ['require','regex'=>'/^1(3[0-9]|4[57]|5[0-35-9]|7[01678]|8[0-9])\d{8}$/','unique'=>'users_info'],
        'dev_id' => 'require|number|notIn:0',
        'from_id' => 'require|number|notIn:0',
        'zx_tool_id' =>  'number|notIn:0',
        'zx_disease_id' =>  'require|number|notIn:0',
        'yy_doctor_id' =>  'number',
        'yy_time' =>  'date'
    ];

    protected $message  =   [
        'username.require' => '请填写客户姓名！',
        'username.max'     => '客户姓名最多不能超过25个字符！',
        'age.number'   => '年龄必须是数字！',
        'age.between'  => '年龄只能在1-120之间！',
        'tel.require'  => '请填写客户手机号！',
        'tel.regex'    => '客户手机号格式错误！',
        'tel.unique'   => '该客户手机号在系统中已经存在，请勿重复添加！',
        'dev_id.notIn' => '请选择开发渠道！',
        'from_id.notIn' => '请选择信息来源！',
        'zx_tool_id.notIn' => '请选择咨询工具！',
        'zx_disease_id.notIn'  => '请选择咨询病种!',
        'yy_time.date' => '预约时间格式不正确！'
    ];

    // 验证场景
    protected $scene = [
        'users_info'  =>  ['username','age','sex','tel','dev_id','from_id'],
        'users_zixun'  =>  ['zx_disease_id','zx_tool_id'],
        'users_yuyue'  =>  ['yy_disease_id','yy_doctor_id','yy_time']
    ];
}
