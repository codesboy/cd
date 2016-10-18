<?php
namespace app\index\model;
use think\Model;
use think\Db;

// 填充表单数据模型

class GetMainData extends Model{
	
	// 获取表单数据
	function getinfo($v){
		$data=Db::name($v)
		->select();
		$total=db($v)->count();;
		$result=[
			'total'=>$total,
			'rows'=>$data
		];//重要，easyui的标准数据格式，数据总数和数据内容在同一个json中

        $result=json($result);
		return $result;
	}

}