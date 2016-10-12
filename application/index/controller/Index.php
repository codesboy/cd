<?php
namespace app\index\controller;
// use think\Controller;
use app\index\model\Menu;
use app\index\model\AddForm;
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

	// 新增客户信息 填充表单数据
	public function useradd(){
		$addform=new AddForm;
		$forminfo=$addform->getinfo('from'); //信息来源
		$disease=$addform->getinfo('disease'); //咨询病种
		$zx_tools=$addform->getinfo('zx_tools'); //咨询工具
		$doctors=$addform->getinfo('doctors'); //预约医生
		$num=build_order_no(); //客户编号 预约号

		$this->assign([
            'forminfo'  => $forminfo,
            'disease' => $disease,
            'zx_tools' => $zx_tools,
            'doctors' => $doctors,
            'num' => $num,
        ]);
		return $this->fetch();
	}


}