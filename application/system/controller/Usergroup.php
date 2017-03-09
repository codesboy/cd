<?php
namespace app\system\controller;
// use app\system\model\Menu;
use think\Validate;
use think\Db;
class Usergroup extends Base{

	public function index(){

		return $this->fetch();
	}


}
