<?php
namespace app\index\model;
use think\Model;
class Login extends Model{
	public function login($username,$password,$code){

		if (!captcha_check($code)) {
            return 4;
        } else {
            // $this->success('验证码正确');
            $user=\think\Db::name('admin')->where('username','=',$username)->find();
            if($user){
            	if($user['password']==md5(md5($password))){
            		return 1;
            	}else{
            		return 2;
            	}
            }else{
            	return 3;
            }
        }





	}
}
