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
		if(Request()->isPost()){
			$data_model=new GetMainData;
			$data=$data_model->getinfo('users_info',input('page'),input('rows'));
			// $data=$data_model->getinfo('users_info');
			return $data;
			// dump($data);

		}else{
			return 'Hello World!';
		}
	}




}
