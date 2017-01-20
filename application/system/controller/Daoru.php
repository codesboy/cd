<?php
namespace app\system\controller;
use app\system\model\AddForm;
use app\system\model\UsersInfo;
// use think\Db;
use \PHPExcel;
use \PHPExcel_IOFactory;
class Daoru extends Base
{
    public function import(){
        $objReader = PHPExcel_IOFactory::createReader('Excel5'); //use Excel5 for 2003 format
        $excelpath="a.xls";
        $objPHPExcel = $objReader->load(ROOT_PATH.$excelpath);
        $sheet = $objPHPExcel->getSheet(0);//// 读取第一個工作表
        $highestRow = $sheet->getHighestRow();           //取得总行数
        $highestColumn = $sheet->getHighestColumn(); //取得总列数


        //从第二行开始读取数据{
        for($j=4;$j<=$highestRow;$j++){
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

            switch ($strs[2]) {
                case '男':
                    $strs[2]=1;
                    break;
                case '女':
                    $strs[2]=2;
                    break;
                default:
                    $strs[2]=0;
                    break;
            }
            $strs[10]=strtotime($strs[10]);
            // echo $strs[2];
            // echo strtotime($strs[10]);

            $user=new UsersInfo;
            $user->data([
                'name'=>$strs[1],
                'usersn'=>$strs[9],
                'sex'=>$strs[2],
                'age'=>$strs[3],
                'telephone'=>$strs[4],
                'create_time'=>$strs[10],
                'update_time'=>$strs[10],
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


}