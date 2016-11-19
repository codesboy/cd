<?php
namespace app\system\model;
use think\Model;
use think\Db;

// 填充表单数据模型

class AddForm extends Model{

	// 获取表单数据
	function getinfo($v){
		$data=Db::name($v)
		// ->field($arr)这里需要加上字段 不要*
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
