<?php
namespace app\index\controller;
// use think\Controller;
use app\index\model\Menu;
// use app\index\model\AddForm;
class Index extends Base
{
	public function index()
	{
		return $this->fetch();
	}

	public function menu(){
		$menu=new Menu();
		$json=$menu->getmenu();
		// dump($json);
		return $json;
	}




}