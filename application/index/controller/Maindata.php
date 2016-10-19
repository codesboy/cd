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
			// $data_model=new GetMainData;
			// $data=$data_model->getinfo('users_info',input('page'),input('rows'));
			// $data=$data_model->getinfo('users_info');
			// return $data;
			// dump($data);
			$user = GetMainData::all();
			

			$aa=new GetMainData;
			// dump($user);//array
			$page=input('page');
			$rows=input('rows');
			$offset=($page-1)*$rows;
			$data=$aa->alias('m')
			->join('dev_from a','a.id=m.dev_id')
			->join('from b','b.id=m.from_id')
			->join('zx_tools c','c.id=m.tool_id')
			->limit($offset,$rows)
			->select();
			
			$total=GetMainData::count();
			$result=[
				'total'=>$total,
				'rows'=>$data
			];
			//重要，easyui的标准数据格式，数据总数和数据内容在同一个json中

	        $result=json($result);
			return $result;

			// dump($result);

		}else{
			return 'Hello World!';
		}
	}

	// 读取用户数据
	public function read($id=''){
	    $user = GetMainData::all();
	    dump($user);//array
	}



}
