<?php
namespace app\index\controller;
use app\index\model\UsersInfo;
use think\Db;
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
			$user1 = UsersInfo::all();


			$user=new UsersInfo;
			// dump($user);//array
			$page=input('page');
			$rows=input('rows');
			$offset=($page-1)*$rows;

			$sort=input('sort')?input('sort'):'u.id';
			$order=input('order')?input('order'):'desc';


			$data=$user->alias('u')
			// $data=Db::name('users_info u,client_consumption uc')
			// $data=Db::name('users_info u')
			->join('consumption con','con.uid=u.id')
			->join('province p','p.province_id=u.province_id','LEFT')
			->join('city c','c.city_id=u.city_id','LEFT')
			->join('county co','co.county_id=u.county_id','LEFT')
			->join('dev_from d','d.id=u.dev_id','LEFT')
			->join('from f','f.id=u.from_id','LEFT')
			->join('zx_tools z','z.id=u.tool_id','LEFT')
			->join('wangdian_zixun w','w.id=u.tool_id','LEFT')
			->join('qiantai_zixun q','q.id=u.tool_id','LEFT')
			->join('doctors doc','doc.id=u.tool_id','LEFT')
			->join('disease dis','dis.id=u.tool_id','LEFT')
			->field('u.id,u.name,u.sex,u.birthday,u.age,u.telephone,p.province_name,c.city_name,co.county_name,d.dev,f.from,z.tool,w.name wdname,q.name qtname,doc.doctor,disease_name,sum(con.money) summoney,addtime')
			->group('u.id')
			->order([$sort=>$order])
			->limit($offset,$rows)
			// ->fetchSql(true)
			->select();
			// echo $data;
			// exit;
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
