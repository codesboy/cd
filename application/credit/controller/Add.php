<?php
namespace app\credit\controller;
use app\index\controller\Base;
use app\index\model\AddForm;
class Add extends Base
{
    public function index()
    {
        $addform=new AddForm;
        $disease=$addform->getinfo('disease'); //病种

        $this->assign([
            'disease' => $disease,

        ]);
        return $this->fetch();
    }
}
