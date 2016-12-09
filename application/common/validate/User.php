<?php
namespace app\common\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'name'  =>  'require|max:25',
        'birthday'  =>  'require|date',
        'telephone' =>  ['require','regex'=>'/^1(3[0-9]|4[57]|5[0-35-9]|7[01678]|8[0-9])\d{8}$/','unique'=>'users_info'],
        'province_id' => 'require|number',
        'city_id' => 'require|number',
        'county_id' => 'number',
        'dev_id' => 'require|number',
        'from_id' => 'require|number',
        'tool_id' => 'require|number',
        'wdzx_id' => 'require|number',
        'qtzx_id' => 'require|number',
        'doctor_id' => 'require|number',
        'disease_id' => 'require|number',
        'jz_time' => 'require|date',
        'money' => 'require|number',
        'ill_desc' => 'require'
    ];

    protected $message  =   [
        'name.require' => '请填写客户姓名！',
        'name.max'     => '客户姓名最多不能超过25个字符！',
        'birthday.require'     => '客户出生日期必选！',
        'birthday.date'     => '客户出生日期格式有误！',
        'telephone.require'  => '请填写客户手机号！',
        'telephone.regex'    => '客户手机号格式错误！',
        'telephone.unique'   => '该客户手机号在系统中已经存在，请勿重复添加！',
        'province_id.require'     => '请选择客户所在省份！',
        'city_id.require'     => '请选择客户所在市！',
        // 'county_id.require'     => '请选择客户所在县区！',
        'dev_id.require' => '请选择开发渠道！',
        'from_id.require' => '请选择信息来源！',
        'tool_id.require' => '请选择咨询工具！',
        'wdzx_id.require' => '请选择网电咨询师！',
        'qtzx_id.require' => '请选择前台咨询师！',
        'doctor_id.require' => '请选择接诊医生！',
        'disease_id.require'  => '请选择咨询病种！',
        'jz_time.require' => '请选择就诊时间！',
        'jz_time.date' => '就诊时间格式错误！',
        'money.require' => '请填写消费金额，未消费请填0',
        'money.number' => '消费金额格式错误！',
        'ill_desc.require' => '请填写病情描述！'
    ];

    // 验证场景
    protected $scene = [
        'users_info'  =>  ['name','birthday','telephone','province_id','city_id','county_id','dev_id','from_id','tool_id'],
        'users_info_consumption'  =>  ['wdzx_id','qtzx_id','doctor_id','disease_id','jz_time','money','ill_desc'],
        'users_consumption'  =>  ['doctor_id','disease_id','jz_time','money','ill_desc']
    ];
}
