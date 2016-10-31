<?php
namespace app\index\model;
use think\Model;
use think\Db;

// 填充表单数据模型

class AddForm extends Model{

	// 获取表单数据
	function getinfo($v){
		$data=Db::name($v)
		->select();
		return $data;
	}

	// 联动
	public function linkage($id){
		$data=Db::name('source')
		->where('pid',$id)
		->select();
		return $data;
	}
}