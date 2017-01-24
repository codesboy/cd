<?php
namespace app\analysis\controller;
use app\system\controller\Base;
use app\system\model\Consumption;
// use think\Db;
class Index extends Base{
    public function index(){
        /*$data=new UsersInfo;
        $xm=$data::all();
        $this->assign('xm',$xm);*/
        return $this->fetch();
    }


    // 销售项目统计
    public function xiangmu(){
        // 原生sql  SELECT a.disease_name,disease_id,COUNT(disease_id) FROM client_consumption AS b,client_disease AS a WHERE a.id=b.disease_id GROUP BY disease_id;

        $data=Consumption::field('disease_id,a.disease_name name,COUNT(disease_id) value')
            ->table('client_consumption b,client_disease a')
            ->where('a.id = b.disease_id')
            // ->where('a.id','b.disease_id')
            ->group('disease_id')
            ->select();
        // dump($data);
        return $data;

    }
}