<?php
namespace app\index\model;
use think\Model;
use think\Db;

class Menu extends Model{
	public function getmenu(){

		
        // 查询数据
        $list = Db::name('menu')
            ->field('menuid,menuname,icon,url')
            ->select();
        // dump($list);
        // return $list;
        $menudata=array();
        $list['menus']=array();
        $menudata['menus']=$list;


        return json_encode($menudata);

	}
}