<?php
namespace app\credit\controller;
use app\system\controller\Base;
use app\credit\model\CreditUsers;
use app\system\model\Admin;
use think\Session;
class Add extends Base
{
    public function index()
    {

        return $this->fetch();
    }

    public function addCreditUser(){
        if(request()->isPost()){
            $info_data=[
                'name'=>input('name'),
                'sex'=>input('sex'),
                'age'=>input('age'),
                'telephone'=>input('telephone'),
                'comment'=>input('comment')
            ];
            $info_data=input('post.');
            $adminId=Admin::getByUsername(Session::get('user_name'));
            $info_data['create_user_id']=$adminId['id'];
            // dump($info_data);
            // exit;
            $validate = validate('Credit');
            if($validate->scene('addparent')->check($info_data)){
                $result=CreditUsers::create($info_data);
                if($result){
                    return '客户添加成功!';
                }
            }else{
                return $validate->getError();
                exit;
            }
        }
    }
}
