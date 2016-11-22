<?php
namespace app\system\controller;
class Dd extends Base{
    public function index(){
        // 开发渠道赋值
        $dev=\think\Db::name('dev_from')->select();
        $this->assign('dev',$dev);
        return $this->fetch();
    }

    // 获取数据字典
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
            exit;
        }
    }
    // 开发渠道列表
    public function devFrom(){
        $dev=\think\Db::name('dev_from')->select();
        $this->assign('dev',$dev);
        return $this->fetch('index');
    }

    // 编辑、新增字典项
    public function edit($tablename=null){
        if(Request()->isPost()){
            $data=input('post.');
            dump(input('post.'));
            // return $tablename;
            $model=model($tablename);
            $model->save($data);
        }
    }


}
