<?php
namespace app\index\controller;
// use think\Controller;
use app\index\model\Menu;
class Index extends Base
{
	public function index()
	{
		
		// session(null);
		// echo '欢迎 '.session('user_name');
		// return '后台主页面';
		return $this->fetch();
	}

	public function menu(){
		$menu=new Menu();
		// var_dump($menu->getmenu());
		// echo $menu->getmenu()['data'];
		$json=$menu->getmenu();
		// dump($json);
		return $json;
	}

}