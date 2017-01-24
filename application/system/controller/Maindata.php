<?php
namespace app\system\controller;
use app\system\model\AddForm;
use app\system\model\UsersInfo;
// use think\Db;
use \PHPExcel;
use \PHPExcel_IOFactory;
class Maindata extends Base
{
	public function index()
	{
		$addform=new AddForm;
		$dev=$addform->getinfo('dev_from'); //开发渠道
		// $from=$addform->getinfo('from'); //信息来源
		$disease=$addform->getinfo('disease'); //病种
		$zx_tools=$addform->getinfo('zx_tools'); //咨询工具
		$doctors=$addform->getinfo('doctors'); //医生
		$province=$addform->getinfo('province'); //省份列表
		$wdzxs=$addform->getinfo('wangdian_zixun'); //网电咨询师
		$qtzxs=$addform->getinfo('qiantai_zixun'); //前台咨询师

		$this->assign([
            'dev'  => $dev,
            // 'from'  => $from,
            'disease' => $disease,
            'zx_tools' => $zx_tools,
            'doctors' => $doctors,
            'province' => $province,
            'wdzxs' => $wdzxs,
            'qtzxs' => $qtzxs,
            'name'=>11

        ]);


		return $this->fetch();
	}

	// 信息来源联动
	public function link($id){
		$addform=new AddForm;
		// dump(input('post.'));
		$from=$addform->linkage($id); //信息来源
		return json($from);

	}



	// 得到用户数据
	// private function getUserData(){
	public function getUserData(){
		$user=new UsersInfo;
		// 分页条件
		$page=input('page');//1 2 3
		$rows=input('rows');//30
		$offset=($page-1)*$rows;//0 30 60

		// 排序条件
		$sort=input('sort')?input('sort'):'u.id';
		$order=input('order')?input('order'):'desc';

		// 模糊查询
		$keywords=input('name');
		$fuzzy=[];
		if(!empty($keywords)){
			$fuzzy['name']=['like',"%{$keywords}%"];
			$fuzzy['telephone']=['like',"%{$keywords}%"];
		}

		// 筛选条件 where()里面可以是数组 可以为空数组
		$moneyRange=[];
		// $startmoney=input('startmoney')?input('startmoney'):0;
		$startmoney=input('startmoney');
		$endmoney=input('endmoney');
		// $endmoney=input('endmoney')?input('endmoney'):100000000;
		if(!empty($startmoney) && !empty($endmoney)){
			$moneyRange['summoney']=['between',[$startmoney,$endmoney]];
			// $moneyRange['summoney']=['between',"$startmoney,$endmoney"];
		}



		$time=input('selecttime')?input('selecttime'):'y';
		$timeWhere=[];
		// $time=input('selecttime');
		if(!empty($time)){
			$timeWhere['jz_time']=[$time];
		}

		// $data=db('users_info')->alias('u')

		$data=$user->alias('u')
			->join('(select a.*,sum(money) summoney from (select * from client_consumption ORDER BY jz_time desc) a group by a.uid ) con','con.uid=u.id')
			->join('client_province p','p.province_id=u.province_id','LEFT')
			->join('client_city c','c.city_id=u.city_id','LEFT')
			->join('client_county co','co.county_id=u.county_id','LEFT')
			->join('client_dev_from d','d.id=u.dev_id','LEFT')
			->join('client_source s','s.id=u.from_id','LEFT')
			->join('client_zx_tools z','z.id=u.tool_id','LEFT')
			->join('client_wangdian_zixun w','w.id=wdzx_id','LEFT')
			->join('client_qiantai_zixun q','q.id=qtzx_id','LEFT')
			->join('client_doctors doc','doc.id=doctor_id','LEFT')
			->join('client_disease dis','dis.id=disease_id','LEFT')
			->field('u.id,u.name,u.sex,u.birthday,u.age,u.telephone,p.province_name,p.province_id,c.city_name,c.city_id,co.county_name,co.county_id,d.dev,source_name,z.tool,wd_name wdname,qt_name qtname,doc.doctor,disease_name,jz_time,summoney,u.create_time')
			->group('u.id')
			->where($moneyRange)
			->whereOr($fuzzy)
			->order([$sort=>$order])
			->limit($offset,$rows)//检索$offset+1到$offset+$rows记录行1-30 31-60
			->whereTime('jz_time',$time)
			// ->whereTime("")
			// ->whereTime($timeWhere)
			->select();
		return $data;
	}

	// 处理全部用户数据给前端使用
	public function returndata(){
		if(Request()->isPost()){

			$data=$this->getUserData();
			// dump($data);die;
			$postData=input('post.');
			// dump(count($postData));die;
			/*if(count($postData)==2){
				$total=UsersInfo::count();
			}else{
				$total=count($data);
			}*/
			$total=UsersInfo::count();
			$result=[
				'total'=>$total,
				'rows'=>$data
			];
			//重要，easyui的标准数据格式，数据总数和数据内容在同一个json中

	        $result=json($result);
			return $result;

			// dump($result);

		}else{
			return 'Hello World!';
		}
	}

	// 读取用户数据
	/*public function read($id=''){
	    $user = GetMainData::all();
	    dump($user);//array
	}*/

	/*public function updateUser(){
	    // if (Request()->isPost()) {
	        // $userid=input('uid');
	        $user=new UsersInfo;
	        $oneUser=$user->field('name,sex,birthday,telephone')->find(5);
	        // $oneUser=$user->field('name,sex,birthday,telephone')->get(5);

	        $data=$oneUser->toArray();

	       // dump($data);die;
	        // $this->assign('data',$data);
	        // return $this->fetch('maindata/index');


	        // $view = new View();
	        $view = new View();
			$view->name = 'thinkphp';
	        return $view->fetch('index');
	    // }
	}*/

	// 导出Excel
	public function export(){
		$objPHPExcel=new PHPExcel;
		// dump($objPHPExcel);die;
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");
		// Add some data
		$oSheet = $objPHPExcel->getActiveSheet(); //获取当前活动sheet标签
		$oSheet->setTitle('成都贝臣齿科客户就诊消费情况表');
		$oSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//居中
		$oSheet->getColumnDimension('B')->setWidth(20);//设置列宽
		$oSheet->getStyle('A1:R1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
		$oSheet->getStyle('A1:R1')->getFill()->getStartColor()->setARGB("#0cedffb");//表头背景颜色
		$oSheet->getStyle('A1:R1')->getFont()->setBold(true);//表头字体加粗
		$arr=range('F','R');
		// var_dump($arr);
		// exit;
		for($i=0;$i<count($arr);$i++){
			$oSheet->getColumnDimension($arr[$i])->setWidth(22);
		}


		// echo $this->returndata()->data;die;
		$data=$this->getUserData();
		// dump($data);die;
		// 填充数据
		// $oSheet->fromArray($row); //此方法占内存
		$j=2;
		foreach ($data as $key => $value) {
			$oSheet->setCellValue('A'.$j,$value['name'])
			->setCellValue('B'.$j,$value['telephone'])
			->setCellValue('C'.$j,$value['sex'])
			->setCellValue('D'.$j,$value['birthday'])
			->setCellValue('E'.$j,$value['age'])
			->setCellValue('F'.$j,$value['province_name'])
			->setCellValue('G'.$j,$value['city_name'])
			->setCellValue('H'.$j,$value['county_name'])
			->setCellValue('I'.$j,$value['dev'])
			->setCellValue('J'.$j,$value['source_name'])
			->setCellValue('K'.$j,$value['tool'])
			->setCellValue('L'.$j,$value['wdname'])
			->setCellValue('M'.$j,$value['qtname'])
			->setCellValue('N'.$j,$value['doctor'])
			->setCellValue('O'.$j,$value['disease_name'])
			->setCellValue('P'.$j,$value['jz_time'])
			->setCellValue('Q'.$j,$value['summoney'])
			->setCellValue('R'.$j,$value['create_time']);
			$j++;
		}
		//

		//插入表头
		// $oSheet->insertNewRowBefore(1,1);
		$objPHPExcel->setActiveSheetIndex(0)
		                        ->setCellValue('A1', '姓名')
		                        ->setCellValue('B1', '手机号码')
		                        ->setCellValue('C1', '性别')
		                        ->setCellValue('D1', '出生日期')
		                        ->setCellValue('E1', '年龄')
		                        ->setCellValue('F1', '所在省份')
		                        ->setCellValue('G1', '所在市区')
		                        ->setCellValue('H1', '所在区县')
		                        ->setCellValue('I1', '开发渠道')
		                        ->setCellValue('J1', '信息来源')
		                        ->setCellValue('K1', '咨询工具')
		                        ->setCellValue('L1', '最近一次网电咨询师')
		                        ->setCellValue('M1', '最近一次前台咨询师')
		                        ->setCellValue('N1', '最近一次接诊医生')
		                        ->setCellValue('O1', '最近一次就诊病种')
		                        ->setCellValue('P1', '最近一次就诊时间')
		                        ->setCellValue('Q1', '消费总金额(元)')
		                        ->setCellValue('R1', '登记时间');

		$date=date("Ymd");
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="成都贝臣齿科客户消费情况表'.$date.'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		// header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0



		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

}
