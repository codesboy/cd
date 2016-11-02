<?php
namespace app\common\validate;

use think\Validate;

class Credit extends Validate{
    protected $rule = [
        'name'  =>  'require|max:25',
        'telephone' =>  ['require','regex'=>'/^1(3[0-9]|4[57]|5[0-35-9]|7[01678]|8[0-9])\d{8}$/','unique'=>'credit_users'],
        'age' => 'number|between:0,120'
    ];

    protected $message  =   [
        'name.require' => '请填写客户姓名！',
        'name.max'     => '客户姓名最多不能超过25个字符！',
        'age.number'     => '年龄必须是数字！',
        'age.between'     => '年龄必须在0-120之间！',
        'telephone.require'  => '请填写客户手机号！',
        'telephone.regex'    => '客户手机号格式错误！',
        'telephone.unique'   => '该客户手机号在系统中已经存在，请勿重复添加！'
    ];
}