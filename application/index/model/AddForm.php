<?php
namespace app\index\model;
use think\Model;
use think\Db;

// 填充表单数据
class AddForm extends Model{
	
	// 
	function getinfo($v){
		$data=Db::name($v)
		->select();
		return $data;
	}
	
	// 联动
	public function linkage($id){
		$data=Db::name('from')
		->where('pid',$id)
		->select();
		return $data;
	}
}