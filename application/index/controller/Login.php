<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Login as Log;
use think\Session;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function check(){

        if(request()->isPost()){
            $login=new Log;//实例化模型
            $AllowLogin=$login->login(input('username'),input('password'),input('code'));
            if($AllowLogin==1){
                Session::set('user_name',input('username'));
                $data["code"] = 1;
                $data['msg']=session('user_name');
                return json($data);
            }elseif($AllowLogin==2){
                // return $this->error('用户名或密码错误！');
                $data["code"] = 2;
                $data["msg"] = "用户名或密码不正确！";
                return json($data);
            }else if($AllowLogin==4){
                $data["code"] = 4;
                $data["msg"] = "验证码错误！";
                return json($data);
            }else{
                $data["code"] = 3;
                $data["msg"] = "该用户不存在！";
                return json($data);
            }
        }
        // echo "1";
    }

    // 退出登录
    public function logout(){
        session(null);
        return $this->success('退出成功!','index');
    }

}
