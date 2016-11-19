<?php
namespace app\system\controller;
class Dd extends Base{
    public function index(){
        return $this->fetch();
    }

    public function getTreeList($table=null){
        if($table && Request()->isPost()){
            $data=db($table)->select();
            // return $data;
            // dump($data);
            $arr=[];
            $k=[];
            foreach ($data[0] as $key => $value) {
                // $k['id']='id';
                // $k['名称']=$key;
                $k[$key]=$key;
            }
            $arr['headers'][0]=$k;
            $arr['bodys']=$data;
            return json($arr);
        }else{
            return ['bodys'=>'没有数据'];
        }
    }
}
