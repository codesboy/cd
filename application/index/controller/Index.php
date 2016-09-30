<?php
namespace app\index\controller;
// use think\Controller;
class Index extends Base
{
	public function index()
	{
		
		// session(null);
		// echo '欢迎 '.session('user_name');
		// return '后台主页面';
		return $this->fetch();
	}



}