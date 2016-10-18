<?php
namespace app\index\controller;
use app\index\model\GetMainData;
class Maindata extends Base
{
	public function index()
	{
		
		return $this->fetch();
		// return 'aa';

	}

	public function returndata(){
		$data_model=new GetMainData;
		$data=$data_model->getinfo('users_info');
		return $data;
		// dump();
	}




}