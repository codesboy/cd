<?php
namespace app\system\controller;
use app\system\model\AddForm;
use app\system\model\UsersTemp;
use app\system\model\UsersTemp2;
use think\Db;
use \PHPExcel;
use \PHPExcel_IOFactory;
use \PHPExcel_Cell;
class Importlst extends Base
{

    public function lst(){
        // $data= UsersTemp2::all()->paginate(10);
        $data= UsersTemp2::paginate(30);
        // $data= UsersTemp2::select()->paginate(10);
        // $data= UsersTemp2::select();
        // dump($data);die;
        $this->assign('data',$data);
        return $this->fetch('index');
    }



    // 导入基本客户资料 医汇通到诊
    public function daoru1(){
        $objReader = PHPExcel_IOFactory::createReader('Excel5'); //use Excel5 for 2003 format
        $excelpath="a.xls";
        $objPHPExcel = $objReader->load(ROOT_PATH.$excelpath);
        $sheet = $objPHPExcel->getSheet(0);//// 读取第一個工作表
        $highestRow = $sheet->getHighestRow();           //取得总行数
        $highestColumn = $sheet->getHighestColumn(); //取得总列数


        //从第二行开始读取数据{
        for($j=3;$j<=$highestRow;$j++){
            $str="";
            for($k='A';$k<=$highestColumn;$k++)            //从A列读取数据
            {
                $str .=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|*|';//读取单元格
            }
            $str=mb_convert_encoding($str,'utf-8','auto');//根据自己编码修改
            $strs = explode("|*|",$str);
            //echo $str . "<br />";
            //exit;
            // $sql = "insert into test (title,content,sn,num) values ('{$strs[0]}','{$strs[1]}','{$strs[2]}','{$strs[3]}')";


            // exit;

            switch ($strs[1]) {
                case '男':
                    $strs[1]=1;
                    break;
                case '女':
                    $strs[1]=2;
                    break;
                default:
                    $strs[1]=0;
                    break;
            }

            // $strs[10]=strtotime($strs[10]);
            // echo $strs[2];
            // echo strtotime($strs[10]);
            // $shared = new \PHPExcel_Shared_Date();

            $user=new UsersTemp2;
            $user->data([

                'xm'=>$strs[0],
                'xb'=>$strs[1],
                'age'=>$strs[2],
                'dh'=>$strs[3],
                'kfqd'=>$strs[4],
                'xxly'=>$strs[5],
                'zxys'=>$strs[6],
                'dzsj'=>strtotime($strs[7]),
                'zxgj'=>$strs[8],
                'fzlb'=>$strs[12],
                'jzys'=>$strs[13],
            ]);
            $result=$user->save();
            // $result=$user->fetchSql()->save();
            // return $user::getLastSql();
            /*if($result){
                return '导入成功';
            }*/
            //echo $sql;
            //exit
        }
    }



    // 导入客户消费（宏脉 客户消费明细表.xls）
    public function daoru2(){
        $objReader = PHPExcel_IOFactory::createReader('Excel5'); //use Excel5 for 2003 format
        $excelpath="b.xls";
        $objPHPExcel = $objReader->load(ROOT_PATH.$excelpath);
        $sheet = $objPHPExcel->getSheet(0);//// 读取第一個工作表


        $highestRow = $sheet->getHighestRow();           //取得总行数
        $highestColumn = $sheet->getHighestColumn(); //取得总列数
        $highestColumnIndex=PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
        // $highestColumn=$highestColumn+1;

        /*echo $highestRow."<br>";
        echo $highestColumn."<br>";
        echo $highestColumnIndex."<br>";
        exit;*/


        //从第四行开始读取数据{
        for($row=4;$row<=$highestRow;$row++){
            // $str="";
            $strs=[];
            // 注意highestColumnIndex的列数从0开始
            for($col=0;$col<=$highestColumnIndex;$col++)            //从A列读取数据
            {

                $strs[$col]=$objPHPExcel->getActiveSheet()->getCellBycolumnAndRow($col,$row)->getValue();
                // dump($strs);
            }


            $user=new UsersTemp;
            $user->data([
                'xm'=>$strs[2],
                'khkh'=>$strs[1],
                'kmlx'=>$strs[8],
                'xfje'=>$strs[15],
                'bz'=>$strs[42],
            ]);
            $result=$user->save();
            // $result=$user->fetchSql()->save();
            // return $user::getLastSql();
            /*if($result){
                return '导入成功';
            }*/
            //echo $sql;
            //exit
        }
    }

    // 合并两张表到新表client_users_temp3
    public function hebing(){
        $temp3=\think\Db::execute('CREATE TABLE client_users_temp3 AS SELECT client_users_temp.xm,client_users_temp.khkh,client_users_temp.kmlx,client_users_temp.xfje,client_users_temp.bz,client_users_temp2.xb,client_users_temp2.age,client_users_temp2.dh,client_users_temp2.kfqd,client_users_temp2.xxly,client_users_temp2.zxys,client_users_temp2.dzsj,client_users_temp2.zxgj,client_users_temp2.fzlb,client_users_temp2.jzys FROM client_users_temp,client_users_temp2 WHERE client_users_temp.xm=client_users_temp2.xm');
        if($temp3){
            // 更新分诊医生字段
            Db::execute("update client_users_temp3 set fzlb=jzys where fzlb=''");
        }

    }

    // 将client_users_temp3的内容插入到users_info表
    public function updateuserinfo(){
        Db::execute("insert into client_users_info (usersn,name,sex,age,telephone,dev_id,from_id,tool_id) select khkh,xm,xb,age,dh,kfqd,xxly,zxgj from client_users_temp3 group by khkh");
    }


}

/**
 * 合并表格
 * CREATE TABLE client_users_temp3 AS
SELECT client_users_temp.xm,client_users_temp.khkh,client_users_temp.kmlx,client_users_temp.xfje,client_users_temp.bz,client_users_temp2.xb,client_users_temp2.age,client_users_temp2.dh,client_users_temp2.kfqd,client_users_temp2.xxly,client_users_temp2.zxys,client_users_temp2.dzsj,client_users_temp2.zxgj,client_users_temp2.fzlb,client_users_temp2.jzys
FROM client_users_temp,client_users_temp2
WHERE client_users_temp.xm=client_users_temp2.xm;


其他sql
#delete from client_users_info where id>50;
#alter table client_users_info auto_increment =50
TRUNCATE client_users_info
#update client_users_temp3 set kfqd='市场转诊' where kfqd='现场咨询';
#select jzys from client_users_temp3 group by jzys;
#select kfqd,xxly from client_users_temp3 group by xxly;
#update client_users_temp3 set fzlb=jzys where fzlb='';


参照表更新
UPDATE client_users_temp3 AS t1, client_disease AS t2
SET
t1.kmlx = t2.id
WHERE t1.kmlx = t2.disease_name

更新消费记录表
FieldTypeComment
id      int(10) unsigned NOT NULL
khkh        var char(255) NULL客户卡号
xm      var char(255) NULL姓名
xb      var char(255) NULL性别
age     small       int(255) NULL年龄
dh      var char(255) NULL电话
kmlx        var char(255) NULL科目类型
kfqd        var char(255) NULL开发渠道
xxly        var char(255) NULL信息来源
zxgj        var char(50) NULL咨询工具
zxys        var char(255) NULL咨询医生
fzlb        var char(255) NULL分诊类别
dzsj        int(11) NULL到诊时间
xfje        int(11) NULL消费金额
bz      var char(1000) NULL备注



FieldTypeComment
id      int(10) unsigned NOT NULL
name        char(20) NOT NULL客户姓名
usersn      char(20) NULL客户编码
sex     tiny        int(1) unsigned NULL性别
birthday        int(11) NULL生日
age     tiny        int(3) unsigned NULL年龄
telephone   char(11) NULL手机号
province_id     mediumint(8) unsigned NULL省份id
city_id     mediumint(8) unsigned NULL市级id
county_id       mediumint(8) unsigned NULL区县id
dev_id          tinyint(3) unsigned NULL开发渠道id
from_id         tinyint(3) unsigned NULL信息来源id
tool_id         tinyint(3) unsigned NULL咨询工具id
create_time     int(10) unsigned NULL登记时间
update_time     int(11) NULL修改时间

insert into client_users_info (usersn,name,sex,age,telephone,dev_id,from_id,tool_id)
select khkh,xm,xb,age,dh,kfqd,xxly,zxgj from client_users_temp3 group by khkh

INSERT INTO client_consumption (uid,wdzx_id,qtzx_id,disease_id,money,jz_time,ill_desc)
SELECT b.id,a.zxys,a.fzlb,a.kmlx,a.xfje,a.dzsj,a.bz FROM client_users_temp3 AS a,client_users_info AS b WHERE a.xfje>0 AND a.khkh=b.usersn


UPDATE client_consumption SET create_time=1485224979,update_time=1485224979


 */