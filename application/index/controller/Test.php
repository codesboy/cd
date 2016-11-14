<?php
namespace app\index\controller;
class Test extends Base {

    public $data;
    public function a(){
        $this->data='aa';
    }

    public function b(){
        $this->a();
        dump($this->data);
    }
}