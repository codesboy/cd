<?php
namespace app\index\controller;
// use app\index\model\Menu;
use think\Validate;
use think\Db;
use app\index\model\AddForm;
use app\index\model\UsersInfo;
class Useradd extends Base{
    public function updateUser(){
        // if (Request()->isPost()) {
            $userid=input('uid');
            $user=UsersInfo::get($userid);

            $name=$user->name;
            $sex=$user->sex;
            $telephone=$user->telephone;
            $birthday=$user->birthday;

            $this->assign([
                'name'  => $name,
                // 'from'  => $from,
                'sex' => $sex,
                'telephone' => $telephone,
                'birthday' => $birthday
            ]);

            return $this->fetch('maindata/index');
        // }
    }
}