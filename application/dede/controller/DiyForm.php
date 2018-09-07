<?php
namespace app\dede\controller;

use think\Controller;
use think\Db;
use app\dede\model\Diyform14 ;
class DiyForm extends Controller
{
    public function getUser($tel)
    {
        // $a = Db::name('diyform14')->where('id',2)->find();
        
        $user=Diyform14::getUserByTel($tel);
        // return json($user);
        return $user;
    }
}

