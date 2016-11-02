<?php
namespace app\credit\controller;
use app\index\controller\Base;
use app\index\model\AddForm;
use app\credit\model\CreditUsers;
class Creditdata extends Base{
    public function index(){
        return $this->fetch();
    }

    public function returnCreditData(){
        $arr=[
            'total'=>12,
            'rows'=>[]
        ];

        return json($arr);
    }
}