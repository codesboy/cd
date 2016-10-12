<?php
namespace app\index\model;
use think\Model;
use think\Db;

// 填充表单数据
class AddForm extends Model{
	
	function getinfo($v){
		$data=Db::name($v)
		->select();
		return $data;
	}
	
}