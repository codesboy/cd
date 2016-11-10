<?php
namespace app\index\controller;
use think\Validate;
use think\View;
use app\index\model\AddForm;
use app\index\model\UsersInfo;
class Editor extends Base{
    public function updateUser(){
        // if (Request()->isPost()) {
            // $userid=input('uid');
            $user=new UsersInfo;
            $oneUser=$user->field('name,sex,birthday,telephone')->find(5);
            // $oneUser=$user->field('name,sex,birthday,telephone')->get(5);

            $data=$oneUser->toArray();

           // dump($data);die;
            $this->assign($data);
            return $this->fetch('maindata/index');


            // $view = new View();
            // return $view->fetch('maindata/index');
        // }
    }
}