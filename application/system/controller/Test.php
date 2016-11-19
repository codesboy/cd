<?php
namespace app\system\controller;
class Test extends Base {

    public $data;//定义成员变量
    public function a(){
        $this->data='aa';
        dump($this->data);//aa
    }

    public function b(){
        $this->a();//为$data变量赋值
        dump($this->data); //aa
    }
}
