<?php
namespace app\system\controller;
use think\Validate;
use think\View;
use app\system\model\AddForm;
use app\system\model\UsersInfo;
class Editor extends Base{
    public function updateUser(){
        // if (Request()->isPost()) {
            // $userid=input('uid');
            $user=new UsersInfo;
            $oneUser=$user->field('name,sex,birthday,telephone')->find(5);
            // $oneUser=$user->field('name,sex,birthday,telephone')->get(5);

            $data=$oneUser->toArray();

           // dump($data);die;
           $name='aa';

            $this->assign('name',$name);
            return $this->fetch('public/editor');


            // $view = new View();
            // return $view->fetch('maindata/index');
        // }
    }
}
