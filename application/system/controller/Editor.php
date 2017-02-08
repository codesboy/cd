<?php
namespace app\system\controller;
use think\Validate;
use think\View;
use app\system\model\AddForm;
use app\system\model\UsersInfo;
class Editor extends Base{
    public function updateUser(){
        if (Request()->isPost()) {
            // dump(input('post.'));die;
            $userid=(int) input('id');
            // dump($userid);
            $user=new UsersInfo;
            if($userid>0){
                // return 'aa';
                $result=UsersInfo::update(input('post.'));
                if($result){
                    return "更新成功";
                }else{
                    return "更新失败";
                }
            }
        }
    }
}
