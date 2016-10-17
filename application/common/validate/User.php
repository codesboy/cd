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
        'tool' =>  'number',
        'disease' =>  'number',
        'doctor' =>  'number',
        // 'addtime' =>  'date',
        // 'usersn' =>  'require|alphaNum|length:16'
    ];

    protected $message  =   [
        'username.require' => '客户姓名必填！',
        'username.max'     => '客户姓名最多不能超过25个字符！',
        'age.number'   => '年龄必须是数字！',
        'age.between'  => '年龄只能在1-120之间！',
        'sex.require'  => '性别必选！',
        'tel.require'  => '客户手机号必填！',
        'tel.regex'    => '客户手机号格式错误！',
        'tel.unique'     => '该客户手机号在系统中已经存在，请勿重复添加！',
        'tool.require' => '咨询工具必选！',
        'disease.require'  => '咨询病种必选！'
    ];

}