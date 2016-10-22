<?php
namespace app\index\controller;
use app\index\model\UsersInfo;
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
			$user = UsersInfo::all();


			$aa=new UsersInfo;
			// dump($user);//array
			$page=input('page');
			$rows=input('rows');
			$offset=($page-1)*$rows;
			$data=$aa->alias('m')
			->join('dev_from a','a.id=m.dev_id')
			->join('from b','b.id=m.from_id')
			->join('zx_tools c','c.id=m.tool_id')
			->order('m.id desc')
			->limit($offset,$rows)
			->select();
			/*echo $data[0]['birthday'];
			exit;*/
			// $age=getAge($data[0]['birthday']);
			$age=getAge('2009-01-03');
			$data['age']=14;

			dump($data);
			exit;
			$total=UsersInfo::count();
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
