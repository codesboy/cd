<?php
namespace app\credit\controller;
use app\index\controller\Base;
// use app\index\model\AddForm;
use app\credit\model\CreditUsers;
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
