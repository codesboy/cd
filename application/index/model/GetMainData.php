<?php
namespace app\index\model;
use think\Model;
use think\Db;
use think\paginator;
// 填充表单数据模型

class GetMainData extends Model{

	// 获取表单数据
	function getinfo($table,$page=1,$rows=10){
	// function getinfo($table){
		//计算当前偏移值
        $offset=($page-1)*$rows;

		/*$data=Db::name($table)->paginate(2,true,[
		    'type'     => 'bootstrap',
		    'var_page' => 'page',
		]);*/
		// ->select();

		//查询指定分页的数据
		$data=Db::name($table)
			->limit($offset,$rows)
			->select();
		$total=db($table)->count();
		$result=[
			'total'=>$total,
			'rows'=>$data
		];//重要，easyui的标准数据格式，数据总数和数据内容在同一个json中

        $result=json($result);
		return $result;
	}

}
